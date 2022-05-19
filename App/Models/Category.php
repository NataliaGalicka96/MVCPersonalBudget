<?php

namespace App\Models;

use PDO;

class Category extends \Core\Models
{

    public function __construct($data = [])
    {
        foreach($data as $key => $value) {
            
            $this -> $key = $value;
        };
    }
  
    public static function assignDefaultCategoriesToNewUser()
    {
        $db = static::getDBConnection();

        $userId = 'SELECT max(user_id) FROM users';

        $sql1="INSERT INTO incomes_category_assigned_to_users (user_id, name)
            SELECT users.id, incomes_category_default.name FROM users, incomes_category_default WHERE users.id = $userId"; 
           
        $assignIncomeCategoriesToUser = $db->prepare($sql1);
        $assignIncomeCategoriesToUser -> execute();
            
        $sql2="INSERT INTO payment_methods_assigned_to_users (user_id, name)
        SELECT users.id, payment_methods_default.name FROM users, payment_methods_default  WHERE users.id = $userId";

    
        $assignPaymentMethodsToUser = $db->prepare($sql2);
        $assignPaymentMethodsToUser -> execute();

        $sql3="INSERT INTO expenses_category_assigned_to_users (user_id, name)
        SELECT users.id, expenses_category_default.name FROM users, expenses_category_default WHERE users.id = $userId";
            
        $assignExpenseCategoriesToUser = $db->prepare($sql3);
        $assignExpenseCategoriesToUser -> execute();
    }















}