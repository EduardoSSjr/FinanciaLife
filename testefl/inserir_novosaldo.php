<?php
include 'conexao.php'; // Inclua o arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_saldo = $_POST['novo_saldo'];
    $sql = "UPDATE saldoatual SET valor_saldoatual = $novo_saldo"; // Atualize o saldo atual com base no ID

    if ($conn->query($sql) === TRUE) {
        echo "Saldo atual atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o saldo atual: " . $conn->error;
    }

    // Redirecione de volta para a página principal após a atualização
    header("Location: listar_valores.php");
}
?>
