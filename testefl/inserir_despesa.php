
<?php
$gasto = $_POST['gasto'];
$desp_data = $_POST['desp_data'];
$valor_despesa = $_POST['valor_despesa'];

// Conexão com o banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'financialife');

// Verificar a conexão
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta SQL para inserção
$sql = "INSERT INTO despesas (gasto, desp_data, valor_despesa) VALUES ('$gasto', '$desp_data', '$valor_despesa')";

// Executar a consulta e verificar se foi bem-sucedida
if ($conn->query($sql) === TRUE) {
    // Redirecione para a página principal ou exiba uma mensagem de sucesso
    header("Location: listar_valores.php");
} else {
    // Exiba uma mensagem de erro em caso de falha na atualização
    echo "Erro ao inserir a despesa: " . $conn->error;
}
// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>