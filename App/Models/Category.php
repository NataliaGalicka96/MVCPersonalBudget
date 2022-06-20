<?php

namespace App\Models;

use PDO;

class Category extends \Core\Model
{

    /**
     * Error messages
     * @var array
     */

    public $errors = [];

    public function __construct($data = [])
    {
        foreach($data as $key => $value) {
            
            $this -> $key = $value;
        };
    }
 
    public static function copy_default_expenses()
	{
		$sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) 
        SELECT users.id, expenses_category_default.name 
        FROM users, expenses_category_default 
        WHERE users.id = (SELECT max(id) FROM users)';
					
		$db = static::getDBConnection();
		
        $stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}
	
	public static function copy_default_incomes()
	{

		$sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) 
        SELECT users.id, incomes_category_default.name 
        FROM users, incomes_category_default 
        WHERE users.id = (SELECT max(id) FROM users)';
		
		$db = static::getDBConnection();
		
        $stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}
	
	public static function copy_default_payment_methods()
	{
		$sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) 
        SELECT users.id, payment_methods_default.name 
        FROM users, payment_methods_default 
        WHERE users.id = (SELECT max(id) FROM users)';
		
		$db = static::getDBConnection();
		
        $stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}


    public static function getCurrentUserIncomeCategories()
    {
        $db = static::getDBConnection();

        $sql = "SELECT ica.id, ica.name
        FROM  incomes_category_assigned_to_users AS ica
        WHERE ica.user_id=:userId";


        $stmt= $db -> prepare($sql);
        $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCurrentUserExpenseCategories()
    {
        $db = static::getDBConnection();

        $sql = "SELECT eca.id, eca.name
        FROM  expenses_category_assigned_to_users AS eca
        WHERE eca.user_id=:userId";

        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt -> execute(); 

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCurrentUserPaymentMethods()
    {
        $db = static::getDBConnection();

        $sql = "SELECT pma.id, pma.name
        FROM  payment_methods_assigned_to_users AS pma
        WHERE pma.user_id=:userId";

        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt -> execute(); 

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function getLimit()
    {
        $db = static::getDBConnection();

        $sql = "SELECT eca.id, eca.name, eca.categoryLimit
        FROM  expenses_category_assigned_to_users AS eca
        WHERE eca.user_id=:userId
        GROUP BY eca.name";

        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt -> execute(); 

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    

}



















