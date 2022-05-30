<?php 

namespace App\Controllers;

use \App\Auth;
use \Core\View;
use \App\Models\User;

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
    
     public function updateAction()
    {
        $user = new User($_POST);
        /*
        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Changes saved');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);

        }
        */
    }
}