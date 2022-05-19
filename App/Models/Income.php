<?php

namespace App\Models;

use PDO;

class Income extends \Core\Model
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

    public function __construct($data)
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

        $this->validate();

        if(empty($this->errors)){

           $income = new Income ($_POST);

           $sql = 'INSERT INTO incomes
           VALUES (NULL, :userId, :category, :amount, :date, :comment)';
           
           $db = static::getDBConnection();

           $stmt = $db->prepare($sql);

           $stmt->bindValue();
           $stmt->bindValue();
           $stmt->bindValue();
           $stmt->bindValue();
           $stmt->bindValue();

           $stmt->execute();
        }

        return false;

      }


    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */

     public function validate()

     {
         
        //Amount must be a number, maximum 2 decimals
        
            if(empty($this->amount )){
                $this->errors['errorAmount1'] = 'Amount is required';
            }

            $incomeAmount = number_format($this->amount, 2, '.','');
            $amountArray = explode('.', $incomeAmount);

            if(!is_numeric($incomeAmount) || strlen($incomeAmount) <0 ||strlen($incomeAmount) >8 || strlen($amountArray[1])>2 || strlen($amountArray[0])>6){

                $this->errors['errorAmount2'] = 'Enter valid positive amount - maximum 6 integer digits and 2 decimal places.';
        
            }


         //Commment max length 100 characters

            if(strlen($this->comment)>100){
                $this->errors['errorComment']= "Comment can contain up to 100 characters";
                
            }

     }

}