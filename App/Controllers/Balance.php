<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\BalanceModel;
use \App\Date;
use \App\Flash;



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
        'firstDate' => $startDate,
        'secondDate' => $endDate
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
        'firstDate' => $startDate,
        'secondDate' => $endDate
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
        'firstDate' => $startDate,
        'secondDate' => $endDate

    ]);
}


    public function showBalancePeriodTimeAction()
    {
        $balance = new BalanceModel($_POST);

        if(!empty($this->date1) && (!empty($this->date2)))
        {
            $startDate=$this->date1;
            $endDate=$this->date2;

            View::renderTemplate('Balance/showBalance.html', [
                'expenseCategories' => BalanceModel::getGroupedExpenses($startDate, $endDate), 
                'sumOfExpenses' => BalanceModel::countExpenses($startDate, $endDate),
                'incomeCategories'	=> BalanceModel::getGroupedIncomes($startDate, $endDate),
                'sumOfIncomes' => BalanceModel::countIncomes($startDate, $endDate),
                'firstDate' => $startDate,
                'secondDate' => $endDate
        ]);
        
        }else{
           //Flash::addMessage("Choose period of time", Flash::WARNING);
            View::renderTemplate('Balance/showBalance.html');


        }


    }
    
}

