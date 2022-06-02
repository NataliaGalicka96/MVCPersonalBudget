<?php 

namespace App\Controllers;

use \App\Auth;
use \Core\View;
use \App\Models\User;
use \App\Models\Category;
use \App\Models\IncomeCategory;
use \App\Models\ExpenseCategory;
use \App\Models\PaymentCategory;
use \App\Flash;


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
     * Show user settings page 
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
     * Show income category page
     */

     public function showIncomeCategorySettingsAction()
     {
        View::renderTemplate('Settings/incomeSettings.html', [
            'incomeCategories' => $this->incomeCategories
        ]);
     }

     /**
     * Edit name category  of income
     *
     * @return void
     */
    
    public function editIncomeCategoryAction()
    {
        $category = new IncomeCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->editCategory()) {

            Flash::addMessage('Your category has been successfully edited.');
            $this -> redirect('/Settings/showIncomeCategorySettings');

        } else {

            View::renderTemplate('Settings/incomeSettings.html', [
                'incomeCategories' => $this->incomeCategories
            ]);

        }
        
    }

    /**
     * Deleting the category and incomes related to that category
     *
     * @return void
     */
    
    public function deleteIncomeCategoryAction()
    {
        $category = new IncomeCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->deleteCategory()) {

            Flash::addMessage('Your category has been successfully deleted.');
            $this -> redirect('/Settings/showIncomeCategorySettings');

        } else {

            View::renderTemplate('Settings/incomeSettings.html', [
                'incomeCategories' => $this->incomeCategories
            ]);

        }
        
    }

     /**
     * Adding the new category of income
     *
     * @return void
     */
    
    public function addIncomeCategoryAction()
    {
        $category = new IncomeCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->addCategory()) {

            Flash::addMessage('Your category has been successfully added.');
            $this -> redirect('/Settings/showIncomeCategorySettings');

        } else {

            View::renderTemplate('Settings/incomeSettings.html', [
                'incomeCategories' => $this->incomeCategories
            ]);

        }
        
    }

    /**
     * 
     * Show expense category page
     */

    public function showExpenseCategorySettingsAction()
    {
       View::renderTemplate('Settings/expenseSettings.html', [
           'expenseCategories' => $this->expenseCategories
       ]);
    }

    /**
     * Edit name category  of expense
     *
     * @return void
     */
    
    public function editExpenseCategoryAction()
    {
        $category = new ExpenseCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->editCategory()) {

            Flash::addMessage('Your category has been successfully edited.');
            $this -> redirect('/Settings/showExpenseCategorySettings');

        } else {

            View::renderTemplate('Settings/expenseSettings.html', [
                'expenseCategories' => $this->expenseCategories
            ]);

        }
        
    }

    /**
     * Deleting the category and expenses related to that category
     *
     * @return void
     */
    
    public function deleteExpenseCategoryAction()
    {
        $category = new ExpenseCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->deleteCategory()) {

            Flash::addMessage('Your category has been successfully deleted.');
            $this -> redirect('/Settings/showExpenseCategorySettings');

        } else {

            View::renderTemplate('Settings/expenseSettings.html', [
                'expenseCategories' => $this->expenseCategories
            ]);

        }
        
    }

     /**
     * Adding the new category of expense
     *
     * @return void
     */
    
    public function addExpenseCategoryAction()
    {
        $category = new ExpenseCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->addCategory()) {

            Flash::addMessage('Your category has been successfully added.');
            $this -> redirect('/Settings/showExpenseCategorySettings');

        } else {

            View::renderTemplate('Settings/expenseSettings.html', [
                'expenseCategories' => $this->expenseCategories
            ]);

        }
        
    }


    /**
     * Show payment method settings page 
     *
     * @return void
     */

    public function showPaymentMethodSettingsAction()
    {
        View::renderTemplate('Settings/paymentSettings.html', [
            'paymentMethods' => $this->paymentMethods
        ]);
    }

        /**
     * Edit name category  of PaymentMethod
     *
     * @return void
     */
    
    public function editPaymentMethodCategoryAction()
    {
        $category = new PaymentCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->editCategory()) {

            Flash::addMessage('Your category has been successfully edited.');
            $this -> redirect('/Settings/showPaymentMethodSettings');

        } else {

            View::renderTemplate('Settings/paymentSettings.html', [
                'paymentMethods' => $this->paymentMethods
            ]);

        }
        
    }

    /**
     * Deleting the PaymentMethod category and expenses related to that category
     *
     * @return void
     */
    
    public function deletePaymentMethodCategoryAction()
    {
        $category = new PaymentCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->deleteCategory()) {

            Flash::addMessage('Your category has been successfully deleted.');
            $this -> redirect('/Settings/showPaymentMethodSettings');

        } else {

            View::renderTemplate('Settings/paymentSettings.html', [
                'paymentMethods' => $this->paymentMethods
            ]);

        }
        
    }

     /**
     * Adding the new category of paymentMethod
     *
     * @return void
     */
    
    public function addPaymentMethodCategoryAction()
    {
        $category = new PaymentCategory($_POST);
        
        //var_dump($_POST);
       
        if ($category->addCategory()) {

            Flash::addMessage('Your category has been successfully added.');
            $this -> redirect('/Settings/showPaymentMethodSettings');

        } else {

            View::renderTemplate('Settings/paymentSettings.html', [
                'paymentMethods' => $this->paymentMethods
            ]);
        }
        
    }


     
}