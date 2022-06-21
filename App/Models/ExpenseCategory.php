<?php

namespace App\Models;

use PDO;

class ExpenseCategory extends \Core\Model
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

    /*
    public static function expenseCategoryAssignedToUser($categoryName, $categoryOldId)
    {
        $db = static::getDBConnection();
        
        $sql = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :name AND id=:idCategory";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':idCategory', $categoryOldId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    */

    public function validateCategoryName()
    {

        if(isset($this->newCategoryName)){
            if($this->newCategoryName == ''){
                $this->errors['categoryName'] = 'Name of category is required.';
            }
        

        if(strlen($this->newCategoryName) < 3 || strlen($this->newCategoryName) > 40){
            $this->errors['categoryName'] = 'Name of category needs to be between 3 to 40 characters.';;
        }

        
        $sql = "SELECT * FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :name";
		
		$db = static::getDBConnection();

		$stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->newCategoryName, PDO::PARAM_STR);

        $stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($result)==1){
		$this->errors['categoryName'] = "Category already exists.";	
		}
        
    }
    
    }

    public function validateLimitAmount()
    {
        //Amount must be a number, maximum 2 decimals
        
        if(isset($this -> categoryLimit)) {
        

            if($this->categoryLimit <0 || $this->categoryLimit >=10000) {
				$this->errors['limitError'] = 'The amount quoted must be between 0 and 10 thousand.';
			}

        }
    }
/*
    public function editCategory()
    {
        $this->validateCategoryName();

        if(empty($this->errors)) {
			$sql = "UPDATE expenses_category_assigned_to_users SET name = :name WHERE id = :id";
			
			$db = static::getDBConnection();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->categoryOldId, PDO::PARAM_INT);
            $stmt->bindValue(':name', $this->newCategoryName, PDO::PARAM_STR);

            return $stmt->execute();
		}
		return false;
        
	}
    */

    public function editCategory()
    {
        $this->validateCategoryName();
        $this->validateLimitAmount();

        if(empty($this->errors['categoryName'])) {
			$sql = "UPDATE expenses_category_assigned_to_users SET name = :name, categoryLimit = :categoryLimit WHERE id = :id";
			
			$db = static::getDBConnection();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->categoryOldId, PDO::PARAM_INT);
            $stmt->bindValue(':name', $this->newCategoryName, PDO::PARAM_STR);
            $stmt->bindValue(':categoryLimit', $this->categoryLimit, PDO::PARAM_INT);

            return $stmt->execute();
		}

        if(empty($this->errors['limitError'])){
            $sql = "UPDATE expenses_category_assigned_to_users SET categoryLimit = :categoryLimit WHERE id = :id";
			
			$db = static::getDBConnection();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->categoryOldId, PDO::PARAM_INT);
            $stmt->bindValue(':categoryLimit', $this->categoryLimit, PDO::PARAM_INT);

            return $stmt->execute();
        }
        
		return false;
        
	}


    public function deleteCategory()
    {
        $this->validateCategoryName();

        if(empty($this->errors)) {
            $sql='DELETE FROM expenses_category_assigned_to_users
            WHERE id=:id';

            $db = static::getDBConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->categoryOldId, PDO::PARAM_INT);

            return $stmt->execute();
		}
		return false;
	}

    public function addCategory()
    {
        $this->validateCategoryName();

        if(empty($this->errors)) {
			$sql = "INSERT INTO expenses_category_assigned_to_users 
            VALUES(NULL, :user_id, :name, :categoryLimit2)";
			
			$db = static::getDBConnection();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $this->newCategoryName2, PDO::PARAM_STR);
            $stmt->bindValue(':categoryLimit2', $this->categoryLimit2, PDO::PARAM_INT);

            return $stmt->execute();
		}
		return false;
	}


    public static function getLimitWithId($categoryId)
    {
        $db = static::getDBConnection();
        
        $sql = "SELECT categoryLimit
        FROM expenses_category_assigned_to_users 
        WHERE  id=:idCategory";
        
        $db = static::getDBConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_STR);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
       
        return $stmt->fetch();


    }


}

