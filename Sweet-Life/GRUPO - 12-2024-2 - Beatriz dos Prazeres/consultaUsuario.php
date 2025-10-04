<?php
include 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];

    // Exclui registros relacionados na tabela log
    $sqlLog = "DELETE FROM log WHERE cadastrados_id = ?";
    $stmtLog = $conn->prepare($sqlLog);
    $stmtLog->bind_param("i", $id);

    if ($stmtLog->execute()) {
        // Exclui o usuário da tabela cadastrados
        $sql = "DELETE FROM cadastrados WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {

            $mensagem = '<div class="alert alert-success text-center mt-4" role="alert">Usuário excluído com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">Erro ao excluir o usuário: ' . $conn->error . '</div>';
        }
    } else {
        $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">Erro ao excluir os registros relacionados: ' . $conn->error . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Usuário - Sweet Life</title>
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/log.css">
</head>

<body>
    <nav class="navbar col-12 position-relative navbar-expand-lg navbar-light bg-light border border-dark" style="z-index: 999;">
        <div class="container-fluid col-11 m-auto">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <figure><a href="index.php">
                    <img src="img/SFLogo.png" id="Logo">
                </a>
            </figure>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php" style="color: rgb(0, 0, 0) ">Início</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br><br><br><br>

    <div id="main-container">
        <h1>Consulta de Usuário</h1>

        <?php if (!empty($mensagem)) echo $mensagem; ?>

        <form action="consultaUsuario.php" method="post">
            <div class="full-box">
                <input type="text" id="nomeBusca" name="nomeBusca" class="form-control" placeholder="Digite o nome do usuário" required>
            </div>
            <input id="btn-submit" type="submit" value="Buscar" name="buscar">
        </form>
    </div><br>

    <?php
    if (isset($_POST['buscar'])) {
        $nomeBusca = $_POST['nomeBusca'];

        $sql = "SELECT * FROM cadastrados WHERE nome LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%" . $nomeBusca . "%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="table-responsive p-5">';
            echo '<table class="table table-bordered table-hover table-striped bg-white">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nome</th>';
            echo '<th>Login</th>';
            echo '<th>Perfil</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
                echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                echo '<td>' . htmlspecialchars($row['perfil']) . '</td>';
                echo '<td>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-user-id="' . $row['id'] . '">Excluir</button></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning text-center mt-4" role="alert">';
            echo 'Nenhum usuário encontrado para "' . htmlspecialchars($nomeBusca) . '".';
            echo '</div>';
        }

        $stmt->close();
    }
    ?>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <form id="deleteForm" method="POST" action="consultaUsuario.php">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <button type="submit" class="btn btn-danger">Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const deleteIdInput = document.getElementById('delete_id');

        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');

            // Define o ID no campo oculto
            deleteIdInput.value = userId;
        });
    </script>
</body>

</html>