<?php 

namespace App\Models;

use PDO;

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
           //$this->validateExpenseData();

           //if(empty($this->errors)){

            $sql = 'INSERT INTO expenses
            VALUES (NULL, :userId, (SELECT eca.id
            FROM expenses_category_assigned_to_users AS eca
            WHERE eca.name = :category_name AND eca.user_id = :userId),
            (SELECT pma.id FROM  payment_methods_assigned_to_users AS pma
            WHERE pma.name = :paymentMethod AND pma.user_id = :userId),
            :amount, :date, :comment)'; 

            $db = static::getDBConnection();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':category_name', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':paymentMethod', $this->payment, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);
 
            return $stmt->execute();
         //}
 
        // return false;
 
       }
}