<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Receita</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
</head>
<body>
    
    <section class="container">
        <form class="receita" action="inserir_receita.php" method="POST">
            <label for="receber">Receita:</label>
            <input type="text" id="receber" name="receber">

            <label for="rec_data">Data:</label>
            <input type="date" id="rec_data" name="rec_data">

            <label for="valor_receita">Valor:</label>
            <input type="number" id="valor_receita" name="valor_receita">

            <button type="submit">Enviar</button>
        </form>
    </section>
    
</body>
</html>