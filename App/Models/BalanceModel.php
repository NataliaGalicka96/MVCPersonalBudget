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

    /**
     * Get data from table of expenses
     * 
     * 
     */

     public static function getGroupedExpenses($startDate, $endDate)
     {

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

     public static function  countExpenses($startDate, $endDate)
     {
         $totalExpense = 0;
         $expenses = static::getGroupedExpenses($startDate, $endDate);

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

     public static function getGroupedIncomes($startDate, $endDate)
     {


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
        $incomeCategoryQuery -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $incomeCategoryQuery -> bindValue(':startDate', $startDate, PDO::PARAM_STR);
        $incomeCategoryQuery -> bindValue(':endDate', $endDate, PDO::PARAM_STR);
        $incomeCategoryQuery -> execute();

        return $incomeCategoryQuery -> fetchAll();
     }

     /**
      * Sum of all incomes from database
      */

      public static function countIncomes($startDate, $endDate)
      {
          $totalIncomes = 0;
          $incomes = static::getGroupedIncomes($startDate, $endDate);

          if(!empty($incomes)){
              foreach($incomes as $income){
                  $totalIncomes += $income['sum'];
              }
          }

          return $totalIncomes;
      }

      /**
       * Get details of incomes
       * 
       */

       public static function getIncomeDetails($startDate, $endDate)
       {
           $sql = "SELECT ica.name, i.amount, i.date_of_income, i.income_comment 
           FROM incomes i
           INNER JOIN incomes_category_assigned_to_users ica
            ON i.income_category_assigned_to_user_id = ica.id
            WHERE i.user_id =:userId AND
            i.date_of_income BETWEEN :startDate AND :endDate
            ORDER BY ica.name";

            $db = static::getDBConnection();

            $stmt = $db -> prepare($sql);
            $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt -> bindValue(':startDate', $startDate, PDO::PARAM_STR);
            $stmt -> bindValue(':endDate', $endDate, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
       }

       /**
       * Get details of expenses
       * 
       */

      public static function getExpenseDetails($startDate, $endDate)
      {
          $sql = "SELECT eca.name, e.amount, e.date_of_expense, e.expense_comment 
          FROM expenses e
          INNER JOIN expenses_category_assigned_to_users eca
            ON e.expense_category_assigned_to_user_id = eca.id
            INNER JOIN Payment_methods_assigned_to_users pma
            ON e.payment_method_assigned_to_user_id = pma.id
           WHERE e.user_id =:userId AND
           e.date_of_expense BETWEEN :startDate AND :endDate
           ORDER BY eca.name";

           $db = static::getDBConnection();

           $stmt = $db -> prepare($sql);
           $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
           $stmt -> bindValue(':startDate', $startDate, PDO::PARAM_STR);
           $stmt -> bindValue(':endDate', $endDate, PDO::PARAM_STR);
           $stmt -> execute();

           return $stmt -> fetchAll();
      }

    }