
<?php
$gasto = $_POST['gasto'];
$desp_data = $_POST['desp_data'];
$valor_despesa = $_POST['valor_despesa'];
$parcelado = isset($_POST['tipo_transacao']) && $_POST['tipo_transacao'] === 'parcelado' ? true : false;
$quantidade_parcelas = $parcelado ? $_POST['quantidade_parcelas'] : null;

// Conexão com o banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'financialife');

// Verificar a conexão

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta SQL para inserção
$sql = "INSERT INTO despesas (gasto, desp_data, valor_despesa, parcelado, quantidade_parcelas)
        VALUES ('$gasto', '$desp_data', '$valor_despesa', '$parcelado', '$quantidade_parcelas')";

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
