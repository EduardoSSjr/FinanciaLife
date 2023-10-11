// Dados de exemplo
var data = {
    labels: ['Despesas', 'Receitas'],
    datasets: [{
        data: [400, 400], // Valores de exemplo para despesas e receitas
        backgroundColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
        borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
        borderWidth: 1
    }]
};

// Configurar o gráfico de pizza
var ctx = document.getElementById('meuGrafico').getContext('2d');
var meuGrafico = new Chart(ctx, {
    type: 'pie',
    data: data,
});

