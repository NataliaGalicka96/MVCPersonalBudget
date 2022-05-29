<?php 

namespace App\Controllers;

use \App\Auth;
use \Core\View;

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

    public function showAction()
    {
        View::renderTemplate('Settings/settings.html', [
            'user' => $this->user
        ]);
    }
}