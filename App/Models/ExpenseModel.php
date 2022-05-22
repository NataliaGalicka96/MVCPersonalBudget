<?php 

namespace App\Models;

use PDO;
use \App\Date;

class ExpenseModel extends \Core\Model
{
    /**
     * Error messages
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
       * Save new expense to database
       * 
       * @return boolean True if the user was saved, false otherwise
       */

       public function saveExpenseToDB()
       {
           $this->validateExpenseData();

           if(empty($this->errors)){

            $sql = 'INSERT INTO expenses
            VALUES (NULL, :userId, (SELECT eca.id
            FROM expenses_category_assigned_to_users AS eca
            WHERE eca.name = :category_name AND eca.user_id = :userId),
            (SELECT pma.id FROM  payment_methods_assigned_to_users AS pma
            WHERE pma.name = :paymentMethod AND pma.user_id = :userId),
            :amount, :date, :comment)'; 

            $db = static::getDBConnection();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_STR);
            $stmt->bindValue(':category_name', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':paymentMethod', $this->payment, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
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

     public function validateExpenseData()
     {
         
        //Amount must be a number, maximum 2 decimals
        
        if(isset($this -> amount)) {
            
            if(empty($this -> amount)) {

                $this->errors['amountError'] = 'Amount is required';
            
            }

            if($this->amount <0 || $this->amount >=1000000) {
				$this->errors['amountError'] = 'The amount quoted must be between 0 and 1 million.';
			}

        }


        //Category validation

        if(!isset($this -> category)) {
            
            $this -> errors['categoryError'] = 'Expense category is required.';
        
        }

        //Payment method validation

        //Category validation

        if(!isset($this -> payment)) {
            
            $this -> errors['paymentError'] = 'Payment method is required.';
        
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