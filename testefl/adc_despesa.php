<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Despesa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
</head>
<body>
    
    <section class="container">
        <form class="despesa" action="inserir_despesa.php" method="POST">
            <label for="gasto">Despesa:</label>
            <input type="text" id="gasto" name="gasto">

            <label for="desp_data">Data:</label>
            <input type="date" id="desp_data" name="desp_data">

            <label for="valor_despesa">Valor:</label>
            <input type="number" id="valor_despesa" name="valor_despesa">

            <!-- Adicione os campos para escolher entre Valor Unitário e Parcelado -->
            <label for="tipo_transacao">Tipo de Transação:</label>
            <label for="valor_unitario">Valor Unitário</label>
            <input type="radio" id="valor_unitario" name="tipo_transacao" value="unitario" checked>
            <label for="parcelado">Parcelado</label>
            <input type="radio" id="parcelado" name="tipo_transacao" value="parcelado">

            <!-- Campo para inserir o número de parcelas -->
            <div id="campo_parcelas" style="display: none;">
                <label for="quantidade_parcelas">Número de Parcelas:</label>
                <input type="number" id="quantidade_parcelas" name="quantidade_parcelas">
            </div>

            <button type="submit">Enviar</button>
        </form>
    </section>    

    <script>
        // Use JavaScript para controlar a visibilidade do campo de parcelas
        var tipoTransacao = document.querySelector('input[name="tipo_transacao"]:checked').value;
        var campoParcelas = document.getElementById('campo_parcelas');

        if (tipoTransacao === 'parcelado') {
            campoParcelas.style.display = 'block';
        } else {
            campoParcelas.style.display = 'none';
        }

        // Adicione um ouvinte de evento para atualizar a visibilidade quando o usuário alterar a seleção
        document.querySelectorAll('input[name="tipo_transacao"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var tipoTransacao = document.querySelector('input[name="tipo_transacao"]:checked').value;

                if (tipoTransacao === 'parcelado') {
                    campoParcelas.style.display = 'block';
                } else {
                    campoParcelas.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
