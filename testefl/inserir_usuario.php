
<?php
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Conexão com o banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'financialife');

// Verificar a conexão
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta SQL para inserção
$sql = "INSERT INTO usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

// Executar a consulta e verificar se foi bem-sucedida
if ($conn->query($sql) === TRUE) {
    // Redirecione para a página principal ou exiba uma mensagem de sucesso
    header("Location: listar_valores.php");
}
// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

