<?php 

namespace App\Controllers;

use \Core\View;


class Balance extends Authenticated
{


    /**
     * Show the balance of current date page
     * 
     * @return void
     */
    public function balanceOfCurrentMonthAction()
    {
        View::renderTemplate('Balance/balanceOfCurrentMonth.html');
    }
}