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
     * Get all the incomes as an associative array
     *
     * @return array
     */

     public static function getAllIncomes()
     {
        
     }
}