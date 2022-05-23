<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceModel;
use \App\Date;



class Balance extends Authenticated
{

public function showBalanceCurrentMonthAction()
{
    $startDate = Date::getFirstDayOfCurrentMonth();
	$endDate = Date::getLastDayOfCurrentMonth();


    View::renderTemplate('Balance/showBalance.html', [
		'expenseCategories' => BalanceModel::getGroupedExpenses($startDate, $endDate), 
        'sumOfExpenses' => BalanceModel::countExpenses($startDate, $endDate),
        'incomeCategories'	=> BalanceModel::getGroupedIncomes($startDate, $endDate),
        'sumOfIncomes' => BalanceModel::countIncomes($startDate, $endDate),
        'firstDate' => Date::getFirstDayOfCurrentMonth(),
        'secondDate' => Date::getLastDayOfCurrentMonth()
    ]);
}
public function showBalancePreviousMonthAction()
{
    $startDate = Date::getFirstDayOfPreviousMonth();
	$endDate = Date::getlastDayOfPreviousMonth();

    View::renderTemplate('Balance/showBalance.html', [
		'expenseCategories' => BalanceModel::getGroupedExpenses($startDate, $endDate), 
        'sumOfExpenses' => BalanceModel::countExpenses($startDate, $endDate),
        'incomeCategories'	=> BalanceModel::getGroupedIncomes($startDate, $endDate),
        'sumOfIncomes' => BalanceModel::countIncomes($startDate, $endDate),
        'firstDate' => Date::getFirstDayOfPreviousMonth(),
        'secondDate' => Date::getlastDayOfPreviousMonth()
    ]);
}

public function showBalanceCurrentYearAction()
{

    $startDate=Date::getFirstDayOfCurrentYear();
    $endDate=Date::getLastDayOfCurrentYear();

    View::renderTemplate('Balance/showBalance.html', [
        'expenseCategories' => BalanceModel::getGroupedExpenses($startDate, $endDate), 
        'sumOfExpenses' => BalanceModel::countExpenses($startDate, $endDate),
        'incomeCategories'	=> BalanceModel::getGroupedIncomes($startDate, $endDate),
        'sumOfIncomes' => BalanceModel::countIncomes($startDate, $endDate),
        'firstDate' => Date::getFirstDayOfCurrentYear(),
        'secondDate' => Date::getLastDayOfCurrentYear()

    ]);
}

}