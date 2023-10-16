<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Execute uma consulta SQL para obter os detalhes da receita com base no ID
    $sql = "SELECT * FROM receitas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipo = 'receita';
        $titulo = $row['receber'];
        $data = $row['rec_data'];
        $valor = $row['valor_receita'];
    } else {
        // Redirecione ou mostre uma mensagem de erro caso a receita não seja encontrada
    }
} else {
    // Redirecione ou mostre uma mensagem de erro se o parâmetro 'id' não estiver presente na URL
}

// Aqui você cria um formulário para editar os detalhes da receita
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
</head>
<body>

    <section class="container">
    <h1>Editar Receita</h1>
    <form action="atualizar_receita.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Inclua o ID como um campo oculto -->
        <label for="titulo">Título:</label>
        <input type"text" name="titulo" value="<?php echo $titulo; ?>"><br>
        <label for="data">Data:</label>
        <input type="date" name="data" value="<?php echo $data; ?>"><br>
        <label for="valor">Valor:</label>
        <input type="text" name="valor" value="<?php echo $valor; ?>"><br>
        <input type="submit" value="Salvar Alterações">
    </form>
    </section>
</body>
</html>
