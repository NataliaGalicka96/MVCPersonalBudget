<?php 

namespace App\Models;

use PDO;

class ExpenseModel extends \Core\Model
{
    /**
     * Error messages
     * @var array
     */

     public errors = [];

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

      
}