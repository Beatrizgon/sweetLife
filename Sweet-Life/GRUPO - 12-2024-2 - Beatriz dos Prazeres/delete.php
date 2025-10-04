<?php include 'db_connect.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];


    echo "<p>Tem certeza de que deseja excluir este usuário?</p>";
    echo "<a href='delete.php?confirmar=sim&id=$id'>Sim</a> | ";
    echo "<a href='consultaUsuario.php'>Não</a>";


    if (isset($_GET['confirmar']) && $_GET['confirmar'] == 'sim') {

        $sql = "DELETE FROM cadastrados WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Usuário excluído com sucesso!";
        } else {
            echo "Erro ao excluir o usuário: " . $conn->error;
        }

        header('Location: consultaUsuario.php');
        exit();
    }
}
?>
