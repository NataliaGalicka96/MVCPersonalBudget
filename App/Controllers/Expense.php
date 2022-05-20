<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpenseModel;
use \App\Models\Category;

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
}