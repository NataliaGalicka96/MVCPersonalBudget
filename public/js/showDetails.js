
let details = document.getElementById('details');
let categoryName = document.getElementById('categoryNameOfIncome');


let nameOfIncome = document.getElementById('name');
let amount = document.getElementById('amount');
let date = document.getElementById('date');
let comment = document.getElementById('comment');

let categoryNames = document.querySelectorAll('#categoryNameOfIncome');





categoryNames.forEach((category) => {

    let groupedIncomes = [];

    for (let i = 0; i < detailsOfIncome.length; i++) {
        if (detailsOfIncome[i].name == category.innerHTML) {
            groupedIncomes.push(detailsOfIncome[i]);



        }
        nameOfIncome.innerHTML = detailsOfIncome[i].name;
        amount.innerHTML = detailsOfIncome[i].amount;
        date.innerHTML = detailsOfIncome[i].date_of_income;
        comment.innerHTML = detailsOfIncome[i].income_comment;
    }
    console.log(groupedIncomes);





});


/*
    let showDetails = document.querySelectorAll('#details');

    console.log(showDetails);

    showDetails.forEach((detail) =>

        detail.addEventListener("click", console.log("wstaw tabelę"))

    )




    categoryNames.forEach((category) => {

        console.log(category.innerHTML);

        for (let i = 0; i < detailsOfIncome.length; i++) {
            if (detailsOfIncome.name == category.innerHTML) {
                nameOfIncome.innerHTML = detailsOfIncome[i].name;
                amount.innerHTML = detailsOfIncome[i].amount;
                date.innerHTML = detailsOfIncome[i].date_of_income;
                comment.innerHTML = detailsOfIncome[i].income_comment;
            }

        }

    })
*/