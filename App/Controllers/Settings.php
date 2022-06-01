<?php 

namespace App\Controllers;

use \App\Auth;
use \Core\View;
use \App\Models\User;
use \App\Flash;
use \App\Models\Category;

class Settings extends Authenticated
{

    protected $incomeCategories;
    protected $expenseCategories;
    protected $paymentCategories;

    /**
     * Before filter - called before each action method
     *
     * @return void
     */

    protected function before()
    {
        parent::before();

        $this->user = Auth::getLoggedUser();
        $this->incomeCategories = Category::getCurrentUserIncomeCategories(); 
        $this->expenseCategories = Category::getCurrentUserExpenseCategories();
        $this->paymentMethods = Category::getCurrentUserPaymentMethods();
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
     * Edit username
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

    /**
     * Edit email
     *
     * @return void
     */
    
    public function editEmailAction()
    {
        $user = new User($_POST);
       
        if ($user->editEmail()) {

            Flash::addMessage('Email has been successfully edited.');

            $this->redirect('/Settings/showUserSettings');

        } else {

            View::renderTemplate('/Settings/userSettings.html', [
                'user' => $this->user
            ]);

        }
        
    }

    /**
     * Edit password
     *
     * @return void
     */
    
    public function editPasswordAction()
    {
        $user = new User($_POST);
       
        if ($user->editPassword()) {

            Flash::addMessage('Password has been successfully edited.');

            $this->redirect('/Settings/showUserSettings');

        } else {

            View::renderTemplate('/Settings/userSettings.html', [
                'user' => $this->user
            ]);

        }
        
    }

    /**
     * 
     * Show income categories page
     */

     public function showIncomeCategorySettingsAction()
     {
        View::renderTemplate('Settings/incomeSettings.html', [
            'incomeCategories' => $this->incomeCategories
        ]);
     }
}