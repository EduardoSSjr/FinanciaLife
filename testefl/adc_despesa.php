<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Despesa</title>
</head>
<body>
    
<form class="despesa" action="inserir_despesa.php" method="POST">
    <label for="gasto">Despesa:</label>
    <input type="text" id="gasto" name="gasto">

    <label for="desp_data">Data:</label>
    <input type="date" id="desp_data" name="desp_data">

    <label for="valor_despesa">Valor:</label>
    <input type="number" id="valor_despesa" name="valor_despesa">

    <button type="submit">Enviar</button>
</form>
    
</body>
</html>