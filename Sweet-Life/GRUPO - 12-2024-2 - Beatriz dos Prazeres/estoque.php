<?php
session_start();
include('db_connect.php');


if (isset($_POST['delete_produto'])) {
    $id_produto_excluir = $_POST['id_produto_excluir'];

    $delete_query = "DELETE FROM produtos WHERE id_produtos = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_produto_excluir);

    if ($stmt->execute()) {

        header("Location: estoque.php");
        exit();
        echo "<script>alert('Erro ao excluir o produto.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_produtos']) && isset($_POST['estoque'])) {
    $id_produto = $_POST['id_produtos'];
    $estoque = $_POST['estoque'];

    $update_query = "UPDATE produtos SET estoque = ? WHERE id_produtos = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ii", $estoque, $id_produto);

    if ($stmt->execute()) {

        header("Location: estoque.php");
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar o estoque.');</script>";
    }
}

$query = "SELECT * FROM produtos";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/log.css">
    <title>Estoque - Sweet Life</title>
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
                        <a class="nav-link" aria-current="page" href="index.php" style="color: rgb(0, 0, 0)">Início</a>
                    </li>
            </div>
    </nav><br><br><br><br>

    <div class="container mt-5">
        <h1 class="text-center text-light">Estoque</h1>
        <table class="table table-bordered border border-black">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['descricao']; ?></td>
                        <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo $row['estoque']; ?></td>
                        <td>

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id_produtos']; ?>">Alterar Estoque</button>

                            <div class="modal fade" id="editModal<?php echo $row['id_produtos']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Alterar Estoque</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="estoque.php" method="POST">
                                                <input type="hidden" name="id_produtos" value="<?php echo $row['id_produtos']; ?>">
                                                <div class="mb-3">
                                                    <label for="estoque" class="form-label">Quantidade em Estoque</label>
                                                    <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo $row['estoque']; ?>" required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Atualizar Estoque</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><br><br>


                            <form action="estoque.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_produto_excluir" value="<?php echo $row['id_produtos']; ?>">
                                <button type="submit" name="delete_produto" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>