
<?php
include 'conexao.php'; // Inclua o arquivo de conexão com o banco de dados

// Recupere o mês atual no formato "aaaa-mm"
$mes_atual = date("Y-m");

$sql = "SELECT * FROM  despesas 
            UNION
            SELECT * FROM receitas";

// Consulta SQL para somar as despesas do mês atual
$sql_depesas = "SELECT SUM(valor_despesa) AS total_despesas FROM despesas WHERE DATE_FORMAT(desp_data, '%Y-%m') = '$mes_atual'";
$result_despesas = $conn->query($sql_depesas);
$row_despesas = $result_despesas->fetch_assoc();
$total_despesas = $row_despesas['total_despesas']; 

// Consulta SQL para somar as receitas do mês atual
$sql_receitas = "SELECT SUM(valor_receita) AS total_receitas FROM receitas WHERE DATE_FORMAT(rec_data, '%Y-%m') = '$mes_atual'";
$result_receitas = $conn->query($sql_receitas);
$row_receitas = $result_receitas->fetch_assoc();
$total_receitas = $row_receitas['total_receitas'];

// Preparar os dados para o gráfico em formato JSON
$dados_grafico = [
    'Despesas' => $total_despesas,
    'Receitas' => $total_receitas
];

// Converter os dados para JSON
$dados_json = json_encode($dados_grafico);



// Agora você tem os dados no formato JSON que pode ser usado no seu arquivo index.js
?>


<!-- index.php -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanciaLife</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo_telaprincipal.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>

    <!-- menu header -->
    <header>
        <div class="menu">
            <div class="menu-left">
                <a href="#">☰</a> <!-- Ícone para o menu (pode ser ativado com JavaScript) -->
                <a href="#">Logo</a> <!-- Logotipo -->
            </div>
            <div class="menu-right">
                <a class="menu-adc-part" href="#">+Adc. Participante</a> <!-- Link para adicionar participante -->
                <a class="menu-entrar" href="login.html">Entrar</a> <!-- Link para página de login -->
            </div>
        </div>
    </header>
    <div class="menu-spacing"></div>
    
    <!-- parte lateral esquerda -->
    <aside class="barra-lateral-esquerda">
        <h2 class="titulo-sidebar-esquerda">Gastos Mensais</h2> <!-- Título da barra lateral esquerda -->

        <div class="espaco-gastos-mensais-atual">
            <h3>Este Mês</h3> <!-- Título para a seção de gastos atuais -->
            
            <canvas id="meuGrafico"></canvas>

        </div>

        <div class="tabela-spacing"></div> <!-- Espaço entre seções -->

        <div class="espaco-tabela-proximos">
            <table>
                <h3 class="titulo-sidebar-atual">Próximo</h3> <!-- Título para a seção de próximos gastos -->
                <!-- Linhas da tabela para listar valores -->
                <tr>
                    <td>Conteudo 01</td>
                </tr>
                <tr>
                    <td>Conteudo 01</td>
                </tr>
                <tr>
                    <td>Conteudo 01</td>
                </tr>
                <tr>
                    <td>Conteudo 01</td>
                </tr>
            </table>
        </div>
    </aside>

    <!-- parte lateral direita -->
    <section class="barra-lateral-direita">
        <header>
            <h2 class="titulo-sidebar-direita">Suas Finanças</h2> <!-- Título da barra lateral direita -->
        </header>

        <div class="botoes-barra-direita">
            <!--  USO FUTURO -->
            <input class="pesquisar" type="search" placeholder="Pesquisar"> <!-- Campo de pesquisa (uso futuro) -->
        
            <div class="espaco-saldo-atual">
                <h2 class="titulo-saldo-atual">Saldo Atual</h2> <!-- Título para o saldo atual -->
                <h3 class="saldo-atual">
                    R$ 
                    <?php 
                    $sql = "SELECT valor_saldoatual FROM saldoatual WHERE id = 1"; // Altere o ID conforme necessário
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $valor_saldoatual = $row["valor_saldoatual"];
                        }
                    } else {
                        echo "Nenhum resultado encontrado.";
                    }
                    ?>

                <?php echo $valor_saldoatual; ?>
                    
                </h3> <!-- Valor do saldo atual -->
            </div>
            <a class="botao_editar_saldoatual" href="atualizar_saldo.php">Editar</a>

            <div class="espaco-saldo-prox">
                <h2 class="titulo-saldo-prox">Saldo Prox. Mês</h2> <!-- Título para o saldo atual -->

                <h3 class="saldo-prox">
                <?php
                    // Suponha que você já tem uma conexão ao banco de dados $conn

                    $mes_atual = date("Y-m");
                    // Execute a consulta SQL para obter os valores
                    $queryReceitas = "SELECT SUM(valor_receita) as total_receitas FROM receitas WHERE DATE_FORMAT(rec_data, '%Y-%m') = '$mes_atual'";
                    $queryDespesas = "SELECT SUM(valor_despesa) as total_despesas FROM despesas WHERE DATE_FORMAT(desp_data, '%Y-%m') = '$mes_atual'";
                    $querySaldoAtual = "SELECT valor_saldoatual FROM saldoatual";

                    $resultReceitas = $conn->query($queryReceitas);
                    $resultDespesas = $conn->query($queryDespesas);
                    $resultSaldoAtual = $conn->query($querySaldoAtual);

                    if ($resultReceitas && $resultDespesas && $resultSaldoAtual) {
                        $rowReceitas = $resultReceitas->fetch_assoc();
                        $rowDespesas = $resultDespesas->fetch_assoc();
                        $rowSaldoAtual = $resultSaldoAtual->fetch_assoc();
                        
                        $totalReceitas = $rowReceitas['total_receitas'];
                        $totalDespesas = $rowDespesas['total_despesas'];
                        $saldoAtual = $rowSaldoAtual['valor_saldoatual'];
                        
                        // Calcula o saldo do próximo mês
                        $saldoProximoMes = ($saldoAtual + $totalReceitas) - $totalDespesas;
                        
                        echo "R$ " . $saldoProximoMes . ".00" . "<br>";
                    } else {
                        echo "Erro na consulta SQL.";
                }
                ?>


                </h3> <!-- Valor do saldo atual -->
            </div>
        </div>

        


        <!-- Tabela para os gastos deste mês na barra lateral direita -->
        <div class="espaco-tabela-este-mes">
            <div class="esp">
            <?php
                include_once 'conexao.php';

                $mes_atual = date("Y-m"); // Obtém o mês atual no formato "aaaa-mm"

                // Consulta SQL para listar Despesas e Receitas do mês atual
                $sql = "SELECT 'despesa' AS tipo, id, gasto AS titulo, desp_data AS data, valor_despesa AS valor FROM despesas WHERE DATE_FORMAT(desp_data, '%Y-%m') = '$mes_atual'
                UNION
                SELECT 'receita' AS tipo, id, receber AS titulo, rec_data AS data, valor_receita AS valor FROM receitas WHERE DATE_FORMAT(rec_data, '%Y-%m') = '$mes_atual'
                ORDER BY data ASC";
                $resultado = mysqli_query($conn, $sql);

                echo '<table class="tabela-este-mes">';
                echo '<tr class="titulo-tabela"><th>Tipo</th><th>Título</th><th>Data</th><th>Valor</th><th>Editar</th></tr>';

                while ($linha = mysqli_fetch_assoc($resultado)) {
                    $tipo = ucfirst($linha['tipo']); // Utilize ucfirst para capitalizar a primeira letra
                    $titulo = $linha['titulo'];
                    $data = $linha['data'];
                    $valor = $linha['valor'];

                    // Agora, você pode definir a cor de fundo com base no tipo
                    $background_color = ($linha['tipo'] === 'despesa') ? 'rgba(255, 0, 0, 0.9)' : 'rgba(75, 210, 49, 0.9)';

                    echo "<tr style='background-color: $background_color;'>";
                    echo "<td>$tipo</td>";
                    echo "<td>$titulo</td>";
                    echo "<td>$data</td>";
                    echo "<td>$valor</td>";
                    if ($linha['tipo'] === 'despesa') {
                        echo "<td><a class=\"texto_editar_despesa\" href='editar_despesa.php?id=" . $linha['id'] . "'>Editar</a></td>";
                    } elseif ($linha['tipo'] === 'receita') {
                        echo "<td><a class=\"texto_editar_receita\" href='editar_receita.php?id=" . $linha['id'] . "'>Editar</a></td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
                ?>
        </div>
        <div class="botoes-adicionar">
        <a class="botao-adicionar-despesa" href="adc_despesa.php">Adicionar nova Despesa+</a> <!-- Link para adicionar novo gasto -->
        <a class="botao-adicionar-receita" href="adc_receita.php">Adicionar nova Receita+</a> <!-- Link para adicionar novo gasto -->
        <a class="botao-adicionar-receita" href="adc_saldoatual.php">Adicionar Saldo Atual</a> <!-- Link para adicionar novo gasto -->
        </div>
        </div>

    
    </section>
    



    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Receitas',     10],
          ['Despesas',      10],
        ]);

        var options = {
          title: 'Este mês'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script> -->
    
    <script>
        // Use a variável $dados_json recuperada do PHP
        var data = {
            labels: Object.keys(<?php echo $dados_json; ?>), // As chaves são 'Despesas' e 'Receitas'
            datasets: [{
                data: Object.values(<?php echo $dados_json; ?>), // Os valores são as quantias correspondentes
                backgroundColor: ['rgba(255, 0, 0, 0.8)', 'rgba(75, 210, 49, 0.8)'],
                borderColor: ['rgba(255, 0, 0, 1)', 'rgba(75, 210, 49, 1)'],
                borderWidth: 2
            }]
        };

        // Configurar o gráfico de pizza
        var ctx = document.getElementById('meuGrafico').getContext('2d');
        var meuGrafico = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                color: '#000', // Define a cor do texto como preto
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 18, // Define o tamanho da fonte
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>

<input type="submit" value="Novo pedido"
    onclick="location.href='cadastro_pedido.php'">
<input type="submit" value="SITE"
    onclick="location.href='adc_despesa.php'">

     



