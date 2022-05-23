<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpenseModel;
use \App\Models\Category;
use App\Flash;

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
}