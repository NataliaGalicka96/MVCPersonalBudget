<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

/**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data)
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    };
  }
 
/**
 * 
 * 
 * 
 */

 public function validate()
 {
     //Name
     if($this->name == ''){
        $this->errors[] = 'Name is required';
     }

     //email address
     if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false){
         $this->errors[] = 'Invalid email';
     }

     if($this->emailExists($this->email)){
         $this->errors[]='email already taken';
     }

     //Password

     if (strlen($this->password) < 6) {
        $this->errors[] = 'Please enter at least 6 characters for the password';
    }


     if(preg_match('/.*[a-z]+.*/i', $this->password) == 0){
        $this->errors[] = 'Password needs at least one letter';
     }

     if (preg_match('/.*\d+.*/i', $this->password) == 0) {
        $this->errors[] = 'Password needs at least one number';
    }

 }




  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {

    $this->validate();

    if (empty($this->errors))

    {
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    
        $sql = 'INSERT INTO users (name, email, password_hash)
                VALUES (:name, :email, :password_hash)';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
    
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    return false;
  }


    protected function emailExists($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
 
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
 
        $stmt->execute();
 
        return $stmt->fetch() !== false;
    }

  }




