<?php
 
namespace App\Controllers;
 
use \Core\View;
use \App\Models\User;
 
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{
 
    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }


    /**
     * Sign up a new user
     * 
     * @return void
     */

     public function createAction()
     {
        $user = new User($_POST);

        if($user->save()){
            View::renderTemplate('Signup/success.html');
        }else{
            var_dump($user->errors);
        }

        

     }
}
