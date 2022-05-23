<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceModel;



class Balance extends Authenticated
{

public function showBalanceAction()
{

    View::renderTemplate('Balance/showBalance.html', [
        /*'incomeCategoriesAmount' => BalanceModel::getGroupedIncomes(),*/	
		'expenseCategories' => BalanceModel::getGroupedExpenses(), 
        'sumOfExpenses' => BalanceModel::countExpenses(),
        'incomeCategories'	=> BalanceModel::getGroupedIncomes(),
        'sumOfIncomes' => BalanceModel::countIncomes()
    ]);
}


}