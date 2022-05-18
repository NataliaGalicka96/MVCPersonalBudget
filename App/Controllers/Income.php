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

     public function newAction()
     {
         View::renderTemplate('Income/new-income.html');
     }
}