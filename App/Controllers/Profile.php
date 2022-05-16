<?php

namespace App\Controllers;

use Core\View;
use \App\Auth;

/**
 * Profile controller
 *
 * PHP version 7.0
 */


class Profile extends Authenticated
{
 
    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();
        $this->user = Auth::getUser();
    }



     /**
      * Show the profile 
      *
      *@return void
      */

      public function showAction()
      {
          View::renderTemplate('Profile/show.html', [
              'user'=> Auth::getUser()
          ]);
      }


      /**
     * Show the form for editing the profile
     *
     * @return void
     */

     public function editAction()
     {
         View::renderTemplate('Profile/edit.html', [
             'user' => Auth::getUser()
         ]);
     }

     /**
     * Update the profile
     *
     * @return void
     */
    public function updateAction()
    {

        $user = Auth::getUser();


    }

}
