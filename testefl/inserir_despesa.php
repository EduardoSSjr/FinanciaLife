<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<section class="container">
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
if (mysqli_query($conn, $sql)) {
    echo "Despesa inserida com sucesso";
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