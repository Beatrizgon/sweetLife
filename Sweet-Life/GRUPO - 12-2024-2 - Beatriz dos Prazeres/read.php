<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/consulta.css">
</head>

<body>
    <div id="main-container">
        <form action="read.php" method="post">
        <h1>Consulta de Usuário</h1>
            <div class="full-box">
                <input type="text" id="nomeBusca" name="nomeBusca" class="form-control" placeholder="Digite o nome do usuário" required>
            </div>
            <input id="btn-submit" type="submit" name="buscar" value="Buscar">
        </form>
    </div>

    <?php
    if (isset($_POST['buscar'])) {
        $nomeBusca = $_POST['nomeBusca'];

        // Prepara a consulta para buscar usuários
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
                echo '<td><a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Excluir</a></td>';
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
</body>

</html>
