<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Execute uma consulta SQL para obter os detalhes da despesa com base no ID
    $sql = "SELECT * FROM despesas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipo = 'despesa';
        $titulo = $row['gasto'];
        $data = $row['desp_data'];
        $valor = $row['valor_despesa'];
    } else {
        // Redirecione ou mostre uma mensagem de erro caso a despesa não seja encontrada
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Despesa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionarb.css">
</head>
<body>

    <section class="container">
    <h1>Editar Despesa</h1>
    <form action="atualizar_despesa.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Inclua o ID como um campo oculto -->
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo $titulo; ?>"><br>
        <label for="data">Data:</label>
        <input type="date" name="data" value="<?php echo $data; ?>"><br>
        <label for="valor">Valor:</label>
        <input type="text" name="valor" value="<?php echo $valor; ?>"><br>
        <input type="submit" value="Salvar Alterações">

        <div class="botoes-adc">
        <a style="color: red;" href="excluir_despesa.php?id=<?php echo $id; ?>" class="excluir-button">Excluir Despesa</a>
        <a style="color: black;" href="listar_valores.php">Voltar</a>
        </div>
    </form>
    </section>
</body>
</html>
