<?php
session_start();

include 'db_connect.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("SELECT * FROM cadastrados WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();


        if ($password === $user['password']) {

            $_SESSION['username'] = $username;
            $_SESSION['perfil'] = $user['perfil'];


            $_SESSION['2fa_type'] = rand(0, 1) == 0 ? 'nomeMat' : 'dataNasc';
            header("Location: 2fa.php");
            exit();
        } else {
            $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">Usuário ou Senha incorretos</div>';
        }
    } else {
        echo "Usuário não encontrado.";
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
    <link rel="stylesheet" href="css/Login.css">
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
                </ul>
            </div>
        </div>
    </nav><br><br><br><br>

    <div id="main-container">
        <h1>Entrar</h1>
        
        <?php if (!empty($mensagem)) echo $mensagem; ?>
        <form id="register-form" onsubmit="return handleRegistration()" action="Login.php" method="post">
            <div class="full-box">
                <label for="username">Login</label>
                <input type="text" name="username" id="username" placeholder="Login" minlength="6"
                    maxlength="6" data-required>
            </div>
            <div class="full-box">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Senha"
                    minlength="8" maxlength="8" data-password-validate data-required>
            </div>
            <div><a href="alterar_senha.php">Esqueci minha senha</a></div>
            <div class="full-box">
                <input id="btn-submit" type="submit" value="Registrar">
            </div>
            <div class="full-box">
                <input id="btn-reset" type="reset" value="Limpar">
            </div>
        </form>
        <div class="conta">
            <h3>Não tem uma conta? <a href="Cadastro.php">Cadastre-se agora!</a></h3>
        </div>
    </div>

</body>

</html>