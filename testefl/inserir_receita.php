
<?php
$receber = $_POST['receber'];
$rec_data = $_POST['rec_data'];
$valor_receita = $_POST['valor_receita'];

// Conexão com o banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'financialife');

// Verificar a conexão
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta SQL para inserção
$sql = "INSERT INTO receitas (receber, rec_data, valor_receita) VALUES ('$receber', '$rec_data', '$valor_receita')";

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
