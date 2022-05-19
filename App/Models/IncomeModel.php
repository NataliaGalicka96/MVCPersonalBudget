<?php

namespace App\Models;

use PDO;

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

           $sql = 'INSERT INTO incomes
           VALUES (NULL, :userId, :category, :amount, :date, :comment)';
           
           $db = static::getDBConnection();

           $stmt = $db->prepare($sql);

           $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
           $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
           $stmt->bindValue(':amount', $this->amount, PDO::PARAM_INT);
           $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
           $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

           $stmt->execute();
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

            if(empty($this->amount )){
                $this->errors['errorAmount1'] = 'Amount is required';
            }

            $this->amount = number_format($this->amount, 2, '.','');
            $amount = explode('.', $this->amount);

            if(!is_numeric($this->amount) || strlen($this->amount) <0 || strlen($this->amount) >8 || strlen($amount[1])>2 || strlen($amount[0])>6){

                $this->errors['errorAmount2'] = 'Enter valid positive amount - maximum 6 integer digits and 2 decimal places.';
        
            }
        }

        //Category validation

        if(!isset($this -> category)) {
            
            $this -> errors['categoryError'] = 'Income category is required.';
        
        }

        //Date validation
        if(!isset($this -> date)) {
            
            $this -> validationErrors['dateError'] = 'Date is required.';
        
        }


        //Commment max length 100 characters
        if(isset($this -> comment)) {

            if(strlen($this->comment)>100){
                $this->errors['errorComment']= "Comment can contain up to 100 characters";
                
            }

        }

     }


}