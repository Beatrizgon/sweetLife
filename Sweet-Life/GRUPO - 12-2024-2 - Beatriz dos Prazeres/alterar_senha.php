<?php
session_start();
include 'db_connect.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $novaSenha = $_POST['novaSenha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($novaSenha !== $confirmarSenha) {
        $mensagemErro = "As senhas não coincidem!";
    } elseif (strlen($novaSenha) != 8) {
        $mensagemErro = "A senha deve ter exatamente 8 caracteres!";
    } else {
        // Salva a senha diretamente (sem criptografia)
        $stmt = $conn->prepare("UPDATE cadastrados SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $novaSenha, $email); // Usa a nova senha diretamente

        if ($stmt->execute()) {
            $mensagemSucesso = "Senha alterada com sucesso!";
        } else {
            $mensagemErro = "Erro ao alterar a senha. Verifique seu e-mail.";
        }
        $stmt->close(); // Fecha a declaração preparada
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - Sweet Life</title>
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
            </div>
    </nav><br><br><br><br>


    <div id="main-container">
        <h1>Alterar Senha</h1>

        <?php if (!empty($mensagemErro)): ?>
            <div class="alert alert-danger"><?php echo $mensagemErro; ?></div>
        <?php elseif (!empty($mensagemSucesso)): ?>
            <div class="alert alert-success"><?php echo $mensagemSucesso; ?></div>
        <?php endif; ?>

        <form id="reset-password-form" action="alterar_senha.php" method="post">
            <div class="full-box">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="full-box">
                <label for="novaSenha">Nova Senha</label>
                <input type="password" name="novaSenha" id="novaSenha" placeholder="Nova senha" minlength="8" maxlength="8" required>
            </div>
            <div class="full-box">
                <label for="confirmarSenha">Confirmar Nova Senha</label>
                <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirme a nova senha" minlength="8" maxlength="8" required>
            </div>
            <div class="full-box">
                <input id="btn-submit" type="submit" value="Alterar Senha">
            </div>
            <div><a href="Login.php">Continuar Login</a></div>
        </form>
    </div>
</body>

</html>