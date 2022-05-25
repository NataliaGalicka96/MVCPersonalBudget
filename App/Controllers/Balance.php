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

        if(!empty($_POST['date1']) && (!empty($_POST['date2'])))
        {
            $startDate = $_POST['date1'];
            $endDate = $_POST['date2'];

            //$startDate = date("Ymd", strtotime($firstDate));
            //$endDate = date("Ymd", strtotime($secondDate));

            if($startDate > $endDate){
                $pom = $startDate;
                $startDate=$endDate;
                $endDate=$pom;
            } else if ($startDate < $endDate){
                $startDate = $startDate;
                $endDate = $endDate;
            }

            View::renderTemplate('Balance/showBalance.html', [
                'expenseCategories' => BalanceModel::getGroupedExpenses($startDate, $endDate), 
                'sumOfExpenses' => BalanceModel::countExpenses($startDate, $endDate),
                'incomeCategories'	=> BalanceModel::getGroupedIncomes($startDate, $endDate),
                'sumOfIncomes' => BalanceModel::countIncomes($startDate, $endDate),
                'firstDate' => $startDate,
                'secondDate' => $endDate
        ]);
    } else {
        View::renderTemplate('Balance/showBalance.html');
    }
        

}
}

