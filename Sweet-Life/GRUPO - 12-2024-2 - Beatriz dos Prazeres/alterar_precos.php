<?php
include('db_connect.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto = $_POST['id_produtos'];
    $novo_preco = $_POST['preco'];


    if ($novo_preco < 0) {
        $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">O preço não pode ser negativo!</div>';
    } else {

        $sql = "UPDATE produtos SET preco = '$novo_preco' WHERE id_produtos = '$id_produto'";

        if (mysqli_query($conn, $sql)) {

            $mensagem = '<div class="alert alert-success text-center mt-4" role="alert">Preço atualizado com sucesso!</div>';
        } else {

            $mensagem = '<div class="alert alert-danger text-center mt-4" role="alert">Erro: ' . mysqli_error($conn) . '</div>';
        }
    }
}


$sql = "SELECT * FROM produtos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Preço - Sweet Life</title>
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
        <h2>Alterar Preço</h2>

        <?php if (!empty($mensagem)) echo $mensagem; ?>

        <form method="POST" action="alterar_precos.php">
            <div class="full-box">
                <label for="id_produtos">Selecione o Produto:</label>
                <select name="id_produtos" id="id_produtos" class="form-control">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $row['id_produtos']; ?>"><?php echo $row['nome']; ?></option>
                    <?php endwhile; ?>
                </select><br><br>
            </div>
            <div class="full-box">
                <label for="preco">Novo Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" class="form-control" required><br><br>
            </div>
            <input id="btn-submit" type="submit" value="Alterar">
        </form>
    </div>

</body>

</html>