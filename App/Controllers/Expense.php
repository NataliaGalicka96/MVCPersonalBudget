<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpenseModel;
use \App\Models\Category;
use \App\Models\ExpenseCategory;
use App\Flash;
use \App\Models\BalanceModel;
use \App\Date;

class Expense extends Authenticated
{
    protected $expenseCategories;
    protected $paymentMethods;


    protected function before()
    {
        parent::before();

        $this->expenseCategories = Category::getCurrentUserExpenseCategories();

        $this->paymentMethods = Category::getCurrentUserPaymentMethods();

        
    }

    /**
     * Show the expense page
     * 
     * @return void
     */

     public function newExpenseAction()
     {
         View::renderTemplate('Expense/newExpense.html', [
             'expenseCategories' => $this->expenseCategories,
             'paymentMethods' => $this->paymentMethods
            ]);
     }

    /**
     * Add new expense
     * 
     * @return void
     */

     public function createAction()
     {
         $expense = new ExpenseModel($_POST);

         if($expense -> saveExpenseToDB()){

            Flash::addMessage("Expense has been added", Flash::SUCCESS);
        
            View::renderTemplate('Expense/newExpense.html', [
                'expenseCategories' => $this->expenseCategories,
                'paymentMethods' => $this->paymentMethods
               ]);
        } else {

            Flash::addMessage("There was a problem adding expense. Fill in the necessary fields: amount, payment method, date and category", Flash::WARNING);


            View::renderTemplate('Expense/newExpense.html', [
                'expenseCategories' => $this->expenseCategories,
                'paymentMethods' => $this->paymentMethods,
                'expense' => $expense
            ]);
        }
     }



     public function getExpensesAction()
     {

        $content = trim(file_get_contents("php://input"));

        $_arr = json_decode($content, true);

        $startDate = $_arr["start"];
	    $endDate = $_arr["end"];
       
        //$startDate = Date::getFirstDayOfCurrentMonth();
	   // $endDate = Date::getLastDayOfCurrentMonth();

        echo json_encode( BalanceModel::getGroupedExpenses($startDate, $endDate), JSON_UNESCAPED_UNICODE);
        
   
        //echo json_encode(['success'=>true]);
        //exit();
    }

     public function getLimitAction()
     {
            
      echo json_encode(Category::getLimit(), JSON_UNESCAPED_UNICODE);

    }


    public function expensesAction()
    {
        echo json_encode(Category::getCurrentUserExpenseCategories(), JSON_UNESCAPED_UNICODE);
    }


    public function getLimitWithIdAction()
    {
        $content = trim(file_get_contents("php://input"));

        $_arr = json_decode($content, true);

        $id = $_arr["id"];

        var_dump($id);
	    
        echo json_encode(ExpenseCategory::getLimitWithId($id), JSON_UNESCAPED_UNICODE);
    }
    
}
