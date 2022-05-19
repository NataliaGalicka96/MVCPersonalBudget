<?php

namespace App\Controllers;

use \Core\View;

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

        $income = new Income ($_POST);

      }
}