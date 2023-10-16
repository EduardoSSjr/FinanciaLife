<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Saldo atual</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
</head>
<body>
    <section class="container">
        <form class="saldoatual" action="inserir_saldoatual.php" method="POST">

        <label for="valor_saldoatual">Saldo Atual:</label>
            <input type="number" id="valor_saldoatual" name="valor_saldoatual">

            <button type="submit">Enviar</button>
        </form>
    </section>
</body>
</html>