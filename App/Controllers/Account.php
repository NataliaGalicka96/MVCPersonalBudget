<?php

namespace App\Controllers;

use \App\Models\User;

/**
 * Account controller
 * 
 * PHP version 7.0
 */

 class Account extends \Core\Controller
 {

    /**
     * Validate if email is available (AJAX) for a new signup or an existing user.
     * The ID of an existing user can be passed in in the querystring to ignore when
     * checking if an email already exists or not.
     *
     * @return void
     */
    public function validateEmailAction()
    {
        $is_valid = ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);
 
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

    /**
     * Validate if username is available (AJAX) for a new signup or an existing user.
     * The ID of an existing user can be passed in in the querystring to ignore when
     * checking if a username already exists or not.
     *
     * @return void
     */
    public function validateUsernameAction()
    {
        $is_valid = ! User::usernameExists($_GET['username'], $_GET['ignore_id'] ?? null);
 
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

/*
    public function validateCategoryAction()
    {
        $is_valid = ! IncomeCategory::categoryExists($_GET['newCategoryName'], $_GET['ignore_id'] ?? null);
 
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
*/


 }
 