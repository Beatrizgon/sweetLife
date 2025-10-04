<?php

include 'db_connect.php';


date_default_timezone_set('America/Sao_Paulo');


function getUserName($userId, $conn)
{
    $sql = "SELECT username FROM cadastrados WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['username'];
    } else {
        return "Usuário não encontrado";
    }
}

$searchTerm = "";
$logs = [];


if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchTerm = trim($_GET['search']);


    $sql = "SELECT log.datahora, log.pergunta, log.resposta, log.resultado, cadastrados.username 
            FROM log 
            INNER JOIN cadastrados ON log.cadastrados_id = cadastrados.id
            WHERE cadastrados.username LIKE ? OR cadastrados.cpf LIKE ?
            ORDER BY log.datahora DESC";
    $stmt = $conn->prepare($sql);
    $searchParam = "%" . $searchTerm . "%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sweet Life</title>
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/log.css">
</head>

<body>
    <nav class="navbar col-12 position-relative navbar-expand-lg navbar-light bg-light border border-dark"
        style="z-index: 999;">
        <div class="container-fluid col-11 m-auto">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
            </div>
    </nav><br><br><br><br>


    <div id="main-container">
        <h1>Relatório de Logs de Autenticação</h1>
        <form>
            <div class="full-box">
                <input type="text" id="search" name="search" class="form-control" placeholder="Digite o nome ou CPF" value="<?= htmlspecialchars($searchTerm) ?>">
            </div>
            <input id="btn-submit" type="submit" value="Buscar">
    </div><br>
    </form>
    </div>



    <?php if (!empty($logs)): ?>
        <div class="table-responsive p-5">
            <table class="table table-bordered table-hover table-striped bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Data e Hora</th>
                        <th>Usuário</th>
                        <th>Pergunta</th>
                        <th>Resposta</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i:s', strtotime($log['datahora'])) ?></td>
                            <td><?= htmlspecialchars($log['username']) ?></td>
                            <td><?= htmlspecialchars($log['pergunta']) ?></td>
                            <td><?= htmlspecialchars($log['resposta']) ?></td>
                            <td><?= htmlspecialchars($log['resultado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($searchTerm): ?>
        <div class="alert alert-warning" role="alert">
            Nenhum log encontrado para o termo "<?= htmlspecialchars($searchTerm) ?>".
        </div>
    <?php endif; ?>
    </div>




</body>

</html>