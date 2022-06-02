<?php

namespace App\Models;

use PDO;

class IncomeCategory extends Category
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

    public function validateCategoryName()
    {

        if(isset($this->newCategoryName)){
            if($this->newCategoryName == ''){
                $this->errors['categoryName'] = 'Name of category is required.';
            }
        

        if(strlen($this->newCategoryName) < 3 || strlen($this->newCategoryName) > 40){
            $this->errors['categoryName'] = 'Name of category needs to be between 3 to 40 characters.';;
        }

    }
    
}

    public function editIncomeCategory()
    {
        $this->validateCategoryName();


        $sql = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :name";
		
		$db = static::getDBConnection();

		$stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->newCategoryName, PDO::PARAM_STR);

        $stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($result)==1){
		$this->errors['categoryName'] = "Category already exists.";	
		}

        if (empty($this->errors)) {
			$sql = "UPDATE incomes_category_assigned_to_users SET name = :name WHERE id = :id";
			
			$db = static::getDBConnection();
            $stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->categoryOldId, PDO::PARAM_INT);
            $stmt->bindValue(':name', $this->newCategoryName, PDO::PARAM_STR);

            return $stmt->execute();
		}
		return false;
	}

}