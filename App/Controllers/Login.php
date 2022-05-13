<?php

namespace App\Controllers;

use \Core\View;

/**
 * Login controller
 * 
 * 
 * PHP version 7.0
 */

 class Login extends \Core\Controller
 {
     /**
      * Show the login page
      *
      *@return void
      */

      public function newAction()
      {
        View::renderTemplate('Login/new.html');
      }

      /**
     * Log in a user
     *
     * @return void
     */

     public function createAction()
     {
         echo($_POST['email'].', '.$_POST['password']);
     }
 }