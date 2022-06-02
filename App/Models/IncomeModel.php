<?php

namespace App\Models;

use PDO;
use \App\Date;

class IncomeModel extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */

    public $errors = [];


    /**
     * Class constructor 
     * 
     * @param array $data Initial property values
     * 
     * @return void
     */

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        };
    }

    /**
     * Save income with the current property values
     * 
     *  @return boolean True if the user was saved, false otherwise
     */

      public function saveIncomeToDB()
      {

        $this->validateIncomeData();

        if(empty($this->errors)){

           $income = new IncomeModel ($_POST);

           $incomeAmount = number_format($this->amount, 2, '.', '');

           $sql = 'INSERT INTO incomes
           VALUES (NULL, :userId, (SELECT ica.id
                    FROM  incomes_category_assigned_to_users AS ica
                    WHERE ica.name=:category_name AND ica.user_id =:userId), :amount, :date, :comment)';
           
           $db = static::getDBConnection();

           $stmt = $db->prepare($sql);

           $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_STR);
           $stmt->bindValue(':category_name', $this->category, PDO::PARAM_STR);
           $stmt->bindValue(':amount', $incomeAmount, PDO::PARAM_STR);
           $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
           $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

           return $stmt->execute();
        }

        return false;

      }


    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */

     public function validateIncomeData()
     {
         
        //Amount must be a number, maximum 2 decimals
        
        if(isset($this -> amount)) {
            
            if(empty($this -> amount)) {

                $this->errors['amountError'] = 'Amount is required.';
            
            }
            
            if($this->amount <0 || $this->amount >=1000000) {
				$this->errors['amountError'] = 'The amount quoted must be between 0 and 1 million.';
			}

        }


        //Category validation

        if(!isset($this -> category)) {
            
            $this -> errors['categoryError'] = 'Income category is required.';
        
        }

        //Date validation
        if(!isset($this -> date)) {
            
            $this -> errors['dateError'] = 'Date is required.';
        
        }

        if(isset($this -> date)){

            if($this->date < '2000-01-01' || $this->date > Date::getLastDayOfCurrentMonth())
                {
                    $this->errors['dateError'] = 'The date must be between 2000-01-01 and '.Date::getLastDayOfCurrentMonth().'.';
                }

        }



        //Commment max length 100 characters
        if(isset($this -> comment)) {

            if(strlen($this->comment)>100){
                $this->errors['commentError']= "Comment can contain up to 100 characters.";
                
            }

        }

     }





}