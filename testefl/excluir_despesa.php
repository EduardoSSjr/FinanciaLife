<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Execute uma consulta SQL para excluir a despesa com base no ID
    $sql = "DELETE FROM despesas WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione para a página de listagem de despesas ou exiba uma mensagem de sucesso
        header('Location: listar_valores.php');
    } else {
        // Exiba uma mensagem de erro em caso de falha na exclusão
        echo "Erro ao excluir a despesa: " . $conn->error;
    }
} else {
    // Redirecione ou mostre uma mensagem de erro se o parâmetro 'id' não estiver presente na URL
}
?>
