<?php 

namespace App\Controllers;

use \App\Auth;
use \Core\View;
use \App\Models\User;
use \App\Flash;

class Settings extends Authenticated
{
    /**
     * Before filter - called before each action method
     *
     * @return void
     */

    protected function before()
    {
        parent::before();

        $this->user = Auth::getLoggedUser();
    }

    /**
     * Show settings page
     *
     * @return void
     */

    public function showUserSettingsAction()
    {
        View::renderTemplate('Settings/userSettings.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Update the profile
     *
     * @return void
     */
    
     public function editUsernameAction()
    {
        $user = new User($_POST);
       
        if ($user->editUsername()) {

            Flash::addMessage('Name has been successfully edited.');

            $this->redirect('/Settings/showUserSettings');

        } else {

            View::renderTemplate('/Settings/userSettings.html', [
                'user' => $this->user
            ]);

        }
        
    }
}