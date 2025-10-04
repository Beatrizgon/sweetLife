<?php
session_start();
include('db_connect.php');

$mensagem = ''; // Variável para armazenar as mensagens

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

   
    if ($preco < 0 || $estoque < 0) {
        $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">O preço e o estoque não podem ser negativos!</div>';
    } else {
       
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque) VALUES ('$nome', '$descricao', '$preco', '$estoque')";

        if (mysqli_query($conn, $sql)) {
            $mensagem = '<div class="alert alert-success text-center mt-4" role="alert">Produto registrado com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">Erro: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/log.css">
    <title>Registrar Produto - Sweet Life</title>
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
    </nav>
    <br><br><br><br>
    
    <div id="main-container" class="container">
        <h1>Registrar Novo Produto</h1>

       
        <?php if (!empty($mensagem)) echo $mensagem; ?>

        <form method="POST" action="registrar_prod.php">
            <div class="full-box">
                <label for="nome" class="form-label">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>
            <div class="full-box">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" id="descricao" name="descricao" class="form-control" required>
            </div>
            <div class="full-box">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" class="form-control" required>
            </div>
            <div class="full-box">
                <label for="estoque" class="form-label">Estoque:</label>
                <input type="number" id="estoque" name="estoque" class="form-control" required>
            </div>
            <div class="full-box">
                <input id="btn-submit" type="submit" value="Registrar" class="btn btn-primary mt-3">
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
