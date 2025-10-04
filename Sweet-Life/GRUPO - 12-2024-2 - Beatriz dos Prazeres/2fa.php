<?php
session_start();
include 'db_connect.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

$username = $_SESSION['username'];


$sql = "SELECT nomeMat, dataNasc, cep FROM cadastrados WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!isset($_SESSION['tentativas'])) {
    $_SESSION['tentativas'] = 0;
}

if (!isset($_SESSION['2fa_type']) || isset($_POST['input_2fa'])) {
    $random_value = rand(0, 2);
    $_SESSION['2fa_type'] = $random_value == 0 ? 'nomeMat' : ($random_value == 1 ? 'dataNasc' : 'cep');
}

$authenticated = false;
$input_2fa = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_2fa = trim(strtolower($_POST['input_2fa']));


    if ($_SESSION['2fa_type'] == 'nomeMat' && $input_2fa == strtolower($user['nomeMat'])) {
        $authenticated = true;
    } elseif ($_SESSION['2fa_type'] == 'dataNasc' && $input_2fa == $user['dataNasc']) {
        $authenticated = true;
    } elseif ($_SESSION['2fa_type'] == 'cep' && $input_2fa == $user['cep']) {
        $authenticated = true;
    } else {
        $_SESSION['tentativas']++;
        if ($_SESSION['tentativas'] >= 3) {
            header("Location: Login.php");
            exit();
        } else {
            $random_value = rand(0, 2);
            $_SESSION['2fa_type'] = $random_value == 0 ? 'nomeMat' : ($random_value == 1 ? 'dataNasc' : 'cep');
        }
    }

    // Registra a ação no log
    $datahora = date("Y-m-d H:i:s");
    $pergunta = $_SESSION['2fa_type'];
    $resultado = $authenticated ? 'sim' : 'não';
    $sql_log = "INSERT INTO log (cadastrados_id, datahora, pergunta, resposta, resultado) 
                VALUES ((SELECT id FROM cadastrados WHERE username = ?), ?, ?, ?, ?)";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->bind_param("sssss", $username, $datahora, $pergunta, $input_2fa, $resultado);
    $stmt_log->execute();
}

if ($authenticated) {
    echo "Autenticação bem-sucedida! Bem-vindo, " . $username . "<br>";
    unset($_SESSION['tentativas']);
    header("Location: index.php");
    exit();
} else {
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Autenticação de Usuário</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/2fa.css">
    </head>

    <body>

        <div class="container container-2fa">
            <h2 class="text-center mb-4">Autenticação de Usuário</h2>
            <p class="text-center">Insira o código de autenticação abaixo.</p>

            <form method="post" action="2fa.php">
                <?php if ($_SESSION['2fa_type'] == 'nomeMat'): ?>
                    <div class="mb-3">
                        <label for="input_2fa" class="form-label">Nome da Mãe</label>
                        <input type="text" name="input_2fa" class="form-control text-center" required>
                    </div>
                <?php elseif ($_SESSION['2fa_type'] == 'dataNasc'): ?>
                    <div class="mb-3">
                        <label for="input_2fa" class="form-label">Data de Nascimento (YYYY-MM-DD)</label>
                        <input type="text" name="input_2fa" class="form-control text-center" required>
                    </div>
                <?php elseif ($_SESSION['2fa_type'] == 'cep'): ?>
                    <div class="mb-3">
                        <label for="input_2fa" class="form-label">CEP</label>
                        <input type="text" name="input_2fa" class="form-control text-center" required>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-success w-100" style="border-radius: 20px;">Verificar</button>

                <?php if ($_SESSION['tentativas'] > 0): ?>
                    <p class="text-danger text-center mt-3">
                        Tentativa inválida! Você tem <?= 3 - $_SESSION['tentativas'] ?> tentativas restantes.
                    </p>
                <?php endif; ?>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

<?php
}
?>