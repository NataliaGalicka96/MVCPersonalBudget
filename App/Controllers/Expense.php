<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\ExpenseModel;
use \App\Models\Category;

class Expense extends Authenticated
{
    protected $expenseCategories;


    protected function before()
    {
        parent::before();

    }


    /**
     * Show the expense page
     * 
     * @return void
     */

     public function newExpenseAction()
     {
         
     }
}