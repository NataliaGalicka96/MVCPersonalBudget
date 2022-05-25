window.onload = drawPieChartOfExpenses();
window.onload = drawPieChartOfIncomes();


function drawPieChartOfExpenses() {


    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);


    const expenseArray = [];

    for (let i = 0; i < expenses.length; i++) {

        const singleExpense = {};
        singleExpense.name = (expenses[i][0]);
        singleExpense.sum = (expenses[i][1]);

        expenseArray.push(singleExpense);

    }
    console.log(expenseArray);


    function drawChart() {

        var condArray = [['Category', 'Amount']];

        for (let i = 0; i < expenseArray.length; i++) {
            condArray.push([expenseArray[i].name, parseFloat(expenseArray[i].sum)]);
        }

        console.log(condArray);

        var options = {
            is3D: true,
            legend: {
                textStyle: { color: 'white' }
            },
            backgroundColor: 'transparent',
        };

        var data = google.visualization.arrayToDataTable(condArray)

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
}

function drawPieChartOfIncomes() {


    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);


    const incomeArray = [];

    for (let i = 0; i < incomes.length; i++) {

        const singleIncome = {};
        singleIncome.name = (incomes[i][0]);
        singleIncome.sum = (incomes[i][1]);

        incomeArray.push(singleIncome);

    }
    console.log(incomeArray);


    function drawChart() {

        var condArray = [['Category', 'Amount']];

        for (let i = 0; i < incomeArray.length; i++) {
            condArray.push([incomeArray[i].name, parseFloat(incomeArray[i].sum)]);
        }

        console.log(condArray);

        var options = {
            is3D: true,
            legend: {
                textStyle: { color: 'white' }
            },
            backgroundColor: 'transparent',
        };

        var data = google.visualization.arrayToDataTable(condArray)

        var chart = new google.visualization.PieChart(document.getElementById('piechart_incomes'));
        chart.draw(data, options);
    }
}