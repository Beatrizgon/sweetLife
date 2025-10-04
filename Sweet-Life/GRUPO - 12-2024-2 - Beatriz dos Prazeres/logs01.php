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

// Inicializa as variáveis
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
    <title>Relatório de Logs de Autenticação</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/consulta.css">
</head>
<body>
    <div class="container mt-4">
        <div class="search-container">
            <form method="GET" action="" class="mb-0">
                <h1 class="text-center mb-4">Relatório de Logs de Autenticação</h1>
                <div class="row g-2">
                    <div class="mb-3">
                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            placeholder="Digite o nome ou CPF"
                            value="<?= htmlspecialchars($searchTerm) ?>">
                    </div>
                    <div class="col-md-5 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary w-100 me-2">Buscar</button>
                        <a href="index.php" class="btn btn-secondary w-100">Voltar</a>
                    </div>
                </div>
            </form>
        </div>

        <?php if (!empty($logs)): ?>
            <div class="table-responsive">
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

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
