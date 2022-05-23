<?php

namespace App\Models;

use PDO;
use \App\Date;


class BalanceModel extends \Core\Model
{

    /**
      * Class constructor 
      *
      * @param array $data Initial property values
      *
      * @return void
      */

    public function __construct($data = [])
        {
          foreach ($data as $key => $value){
              $this->$key = $value;
          };
        }

    private static function getFirstDayOfCurrentMonth()
    {
            $startDate = Date::getFirstDayOfCurrentMonth();
            return $startDate;    
    }

    private static function getLastDayOfCurrentMonth()
    {
            $endDate = Date::getLastDayOfCurrentMonth();
            return $endDate;    
    }


    /**
     * Get data from table of expenses
     * 
     * 
     */

     public static function getGroupedExpenses()
     {

        $startDate = static::getFirstDayOfCurrentMonth();
		$endDate = static::getLastDayOfCurrentMonth();

        $sql = "SELECT eca.name ,SUM(e.amount) AS sum
        FROM expenses e
        INNER JOIN expenses_category_assigned_to_users eca
        ON e.expense_category_assigned_to_user_id = eca.id
        WHERE e.user_id =:userId AND
        e.date_of_expense BETWEEN :startDate AND :endDate
        GROUP BY eca.name
        ORDER BY SUM(e.amount) DESC";


        $db = static::getDBConnection();

        $expenseCategoryQuery = $db -> prepare($sql);
        $expenseCategoryQuery -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $expenseCategoryQuery -> bindValue(':startDate', $startDate, PDO::PARAM_STR);
        $expenseCategoryQuery -> bindValue(':endDate', $endDate, PDO::PARAM_STR);
        $expenseCategoryQuery -> execute();

        return $expenseCategoryQuery -> fetchAll();
     }

     /**
      * Sum of all expenses from database
      *
      */

     public static function  countExpenses()
     {
         $totalExpense = 0;
         $expenses = static::getGroupedExpenses();

         if(!empty($expenses)){
             foreach($expenses as $expense){
                $totalExpense +=$expense['sum'];
             }
         }

         return $totalExpense;
     }

    /*
     * Get data from table of incomes
     * 
     * 
     */

     public static function getGroupedIncomes()
     {

        $startDate = static::getFirstDayOfCurrentMonth();
		$endDate = static::getLastDayOfCurrentMonth();


        $sql = "SELECT ica.name ,SUM(i.amount) AS sum
        FROM incomes i
        INNER JOIN incomes_category_assigned_to_users	 ica
        ON i.income_category_assigned_to_user_id = ica.id
        WHERE i.user_id =:userId AND
        i.date_of_income BETWEEN :startDate AND :endDate
        GROUP BY ica.name
        ORDER BY SUM(i.amount) DESC";

        $db = static::getDBConnection();

        $incomeCategoryQuery = $db -> prepare($sql);
        $incomeCategoryQuery -> bindValue(':userId', $loggedUserId, PDO::PARAM_INT);
        $incomeCategoryQuery -> bindValue(':startDate', $startDate, PDO::PARAM_STR);
        $incomeCategoryQuery -> bindValue(':endDate', $endDate, PDO::PARAM_STR);
        $incomeCategoryQuery -> execute();

        return $incomeCategoryQuery -> fetchAll();
     }

     /**
      * Sum of all incomes from database
      */

      public static function countIncomes()
      {
          $totalIncomes = 0;
          $incomes = static::getGroupedIncomes();

          for(!empty($incomes)){
              for($incomes as $income ){
                  $totalIncomes += $income['sum'];
              }
          }

          return $totalIncomes;
      }
     
    }