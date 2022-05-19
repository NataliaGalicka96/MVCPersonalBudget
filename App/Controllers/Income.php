<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;

class Income extends \Core\Controller
{
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
         
        $income = new Income($_POST);

        if ($income -> saveIncomeToDB()){

            View::renderTemplate('Income/newIncome.html', [
                'income' => $income
            ]);
        } else {
            View::renderTemplate('Income/newIncome.html', [
                'income' => $income
            ]);
        }

      }



}