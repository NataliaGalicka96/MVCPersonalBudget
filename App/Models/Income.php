<?php

namespace App\Models;

use PDO;

class Income extends \Core\Model
{

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
     * @return void
     */

      public function saveIncomeToDB()
      {
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

}