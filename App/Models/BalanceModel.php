<?php

namespace App\Models;

use PDO;


class BalanceModel extends \Core\Model
{

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