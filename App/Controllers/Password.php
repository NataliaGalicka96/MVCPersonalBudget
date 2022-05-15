<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Password controller
 * 
 */

 class Password extends \Core\Controller
 {
      /**
     * Show the forgotten password page
     *
     * @return void
     */
    public function forgotAction()
    {
        
    }

    /**
     * Send the password reset link to the supplied email
     * 
     * @return void
     */

     public function requestResetAction()
     {
         User::sendPasswordReset($_POST['email']);

         View::renderTemplate('Password/reseat_requested.html');         
     }

 }