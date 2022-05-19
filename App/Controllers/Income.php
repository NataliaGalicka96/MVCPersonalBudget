<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Category;
use \App\Models\IncomeModel;
use App\Flash;

class Income extends Authenticated
{
    protected $incomeCategories;


    protected function before()
    {
        $this->incomeCategories = Category::getCurrentUserIncomeCategories();
    }
    /**
     * Show the income page
     * 
     * @return void
     */

     public function newIncomeAction()
     {
         View::renderTemplate('Income/newIncome.html');
     }


     /**
      * Add new income
      *
      * @return void
      */
      public function createAction()
      {
         
        $income = new IncomeModel($_POST);

        if ($income -> saveIncomeToDB()){

            Flash::addMessage("Income has been added", Flash::SUCCESS);

            $this->redirect('/income/success');
            
        } else {

            Flash::addMessage("There was a problem adding income. Try again.", Flash::WARNING);

            $this->redirect('/income/failed');
        }

      }

    public function successAction()
    {
        View::renderTemplate('Income/newIncome.html');
    }

    public function failedAction()
    {
        View::renderTemplate('Income/newIncome.html');
    }



}