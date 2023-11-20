<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Execute uma consulta SQL para obter os detalhes da despesa com base no ID
    $sql = "SELECT * FROM receita WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipo = 'receita';
        $titulo = $row['receber'];
        $data = $row['rec_data'];
        $valor = $row['valor_receita'];
    } else {
        // Redirecione ou mostre uma mensagem de erro caso a despesa não seja encontrada
    }
} 
?>
