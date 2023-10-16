<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receita inserida</title>
</head>
<body>

<section class="container">

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
if (mysqli_query($conn, $sql)) {
    echo "Receita inserida com sucesso";
} else {
    echo "Erro ao inserir: " . mysqli_error($conn);
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
<br>
<input class="input-confirmar" type="submit" value="Confirmar" onclick="location.href='listar_valores.php'">

</section>

</body>
</html>