<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];

    // Execute a consulta SQL para atualizar os detalhes da receita no banco de dados
    $sql = "UPDATE receitas SET receber = '$titulo', rec_data = '$data', valor_receita = '$valor' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirecione para a página principal ou exiba uma mensagem de sucesso
        header("Location: listar_valores.php");
    } else {
        // Exiba uma mensagem de erro em caso de falha na atualização
        echo "Erro ao atualizar a receita: " . $conn->error;
    }
} 
