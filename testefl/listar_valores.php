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
    <link rel="stylesheet" href="assets/css/estilo_adicionar.css">
 
    <script src="https://kit.fontawesome.com/cf6fa412bd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,400&display=swap" rel="stylesheet">
</head>
<body>

    <!-- menu header -->
    <header>
        <div class="menu">
            <div class="menu-left">
                <a href="#">☰</a> <!-- Ícone para o menu (pode ser ativado com JavaScript) -->
                <a class="logo" href="#"><img src="assets/imgs/logofl.png" alt="logo financialife"></a> <!-- Logotipo -->
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
            <h3 class="este-mês-titulo">Este Mês</h3> <!-- Título para a seção de gastos atuais -->
            
            <div class="espaco_grafico">
            <canvas class="grafico" id="meuGrafico"></canvas>
            </div>
        </div>

        <div class="tabela-spacing"></div> <!-- Espaço entre seções -->

            <?php 
            $hoje = date("Y-m-d");
            $sql_proximas_despesas = "SELECT id, gasto, desp_data, valor_despesa FROM despesas WHERE DATE(desp_data) >= '$hoje' ORDER BY desp_data ASC LIMIT 2";
            $result_proximas_despesas = $conn->query($sql_proximas_despesas);
            
            $sql_proximas_receitas = "SELECT id, receber, rec_data, valor_receita FROM receitas WHERE DATE(rec_data) >= '$hoje' ORDER BY rec_data ASC LIMIT 2";
            $result_proximas_receitas = $conn->query($sql_proximas_receitas);

            
            echo '<div class="espaco-tabela-proximos">';
            echo '<table>';
            echo '<h3 class="titulo-sidebar-atual">Próximo</h3>';
            echo '<tr>';
            echo '<th style="background-color: var(--secundary-color); color: var(--white)">Título</th>';
            echo '<th style="background-color: var(--secundary-color); color: var(--white)">Data</th>';
            echo '<th style="background-color: var(--secundary-color); color: var(--white)">Valor</th>';
            echo '<th style="background-color: var(--secundary-color); color: var(--white)">Editar</th>';
            echo '</tr>';

            // Loop para as próximas despesas
            while ($row_despesas = $result_proximas_despesas->fetch_assoc()) {
                $data_despesa = date("d/m", strtotime($row_despesas['desp_data']));

                echo '<tr>';
                echo '<td style="background-color: rgba(255, 0, 0, 0.9);">' . $row_despesas['gasto'] . '</td>';
                echo '<td style="background-color: rgba(255, 0, 0, 0.9);">' . $data_despesa . '</td>';
                echo '<td style="background-color: rgba(255, 0, 0, 0.9);">R$ ' . $row_despesas['valor_despesa'] . '</td>';
                echo '<td style="background-color: rgba(255, 0, 0, 0.9);"><a class="texto_editar_despesa" style="color: black;" href="editar_despesa.php?id=' . $row_despesas['id'] . '">Editar</a></td>';
                echo '</tr>';
            }

            // Loop para as próximas receitas
            while ($row_receitas = $result_proximas_receitas->fetch_assoc()) {
                $data_receita = date("d/m", strtotime($row_receitas['rec_data']));

                echo '<tr>';
                echo '<td style="background-color: rgba(75, 210, 49, 0.9);">' . $row_receitas['receber'] . '</td>';
                echo '<td style="background-color: rgba(75, 210, 49, 0.9);">' . $data_receita . '</td>';
                echo '<td style="background-color: rgba(75, 210, 49, 0.9);">R$ ' . $row_receitas['valor_receita'] . '</td>';
                echo '<td style="background-color: rgba(75, 210, 49, 0.9);"><a class="texto_editar_receita" style="color: black;" href="editar_receita.php?id=' . $row_receitas['id'] . '">Editar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</div>';

            ?>
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
                    $sql = "SELECT valor_saldoatual FROM saldoatual"; // Altere o ID conforme necessário
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $valor_saldoatual = $row["valor_saldoatual"];
                            echo $valor_saldoatual;
                        }
                    } else {
                        echo "R$00,00";
                    }
                    ?>

                    
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
                        
                        echo "R$ " . $saldoProximoMes . "<br>";
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
                    $tipo = ucfirst($linha['tipo']);
                    $titulo = $linha['titulo'];
                    
                    // Formate a data no padrão brasileiro
                    $data = date('d/m/Y', strtotime($linha['data']));
                    
                    $valor = $linha['valor'];
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
        <a class="botao-adicionar-despesa user_view btn btn-sm btn-outline-primary">Adicionar nova Despesa</a>
        <a class="botao-adicionar-receita" href="adc_receita.php">Adicionar nova Receita+</a>

        <?php
            include 'conexao.php'; // Inclua o arquivo de conexão com o banco de dados

            // Consulta SQL para verificar se há um valor na tabela 'saldoatual'
            $sql_verificar_saldo = "SELECT COUNT(*) as total_registros FROM saldoatual";
            $result_verificar_saldo = $conn->query($sql_verificar_saldo);
            $row_verificar_saldo = $result_verificar_saldo->fetch_assoc();

            // Verifique se há registros na tabela 'saldoatual'
            if ($row_verificar_saldo['total_registros'] > 0) {
            } else {
                // Exibir o botão
                echo '<a href="adc_saldoatual.php" class="botao-adicionar-saldoatual">Adicionar Saldo Atual</a>';
            }
        ?>

        </div>
        </div>

    
    </section>
        
    <div class="back_screen hidden"></div>
    <modal class="userView_modal m_start hidden">
                <div class="m_wrap">
                    <section class="m_head">
                        <span class="m_title"><span>Inserir Despesa</span></span>
                        <i class="m_close m_userView_close fa-regular fa-circle-xmark fa-xl">X</i>
                    </section>
                        
                    <section class="container">
                    <form class="despesa" action="inserir_despesa.php" method="POST">
                        <label for="gasto">Despesa:</label>
                        <input type="text" id="gasto" name="gasto">

                        <label for="desp_data">Data:</label>
                        <input type="date" id="desp_data" name="desp_data">

                        <label for="valor_despesa">Valor:</label>
                        <input type="number" id="valor_despesa" name="valor_despesa">

                        <button type="submit">Enviar</button>
                    </form>
                </section>    

                </div>
            </modal>
            <script>
                            
                const back_screen = document.querySelector(".back_screen");
                const userView = document.querySelectorAll(".user_view");
                const userView_modal = document.querySelector(".userView_modal");
                const userView_close = document.querySelector(".m_userView_close");

                userView.forEach(button => {
                    button.addEventListener("click", () => {
                        userView_modal.classList.toggle("hidden");
                        back_screen.classList.toggle("hidden");
                    });
                });

                userView_close.addEventListener("click", () => {
                    userView_modal.classList.toggle("hidden");
                    back_screen.classList.toggle("hidden");
                });
            </script>
    
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
                                size: 16, // Define o tamanho da fonte
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

     

