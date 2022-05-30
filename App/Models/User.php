<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \Core\View;


class User extends \Core\Model
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
   * @param array $data  Initial property values
   *
   * @return void
   */
    public function __construct($data=[])
    {
        foreach ($data as $key => $value) {
        $this->$key = $value;
        };
    }
 
    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
        public function validate()
        {
            //username
            if(isset($this->username)){

                if($this->username == ''){
                    $this->errors['usernameError1'] = 'Username is required.';
                }

                if(strlen($this->username)<2 || strlen($this->username)>20){
                    $this->errors['usernameError2'] = "Username needs to be between 2 to 20 characters.";
                }


                if(!preg_match('/^[A-Za-z]+$/', $this->username)){
                    $this->errors['usernameError3'] = "Username must contain letters only. Special characters are not allowed.";
                }

                if(static::usernameExists($this->username, $this-> id ?? NULL)){
                    $this->errors['usernameError4'] = 'Username already taken.';
                }
            }
            //email address

            if(isset($this->email)){

                if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) || filter_var($this -> email, FILTER_SANITIZE_EMAIL) != $this -> email){
                    $this->errors['emailError1'] = 'Please enter a valid e-mail address.';
                }

                if (static::emailExists($this->email, $this->id ?? null)) {
                    $this->errors['emailError2'] = 'Email already taken.';
                }
             
             }

            // Password
            if (isset($this->password)) {
            
                if (strlen($this->password) < 6) {
                    $this->errors['errorPassword1'] = 'Please enter at least 6 characters for the password';
                }

                if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                    $this->errors['errorPassword2'] = 'Password needs at least one letter';
                }

                if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                    $this->errors['errorPassword3'] = 'Password needs at least one number';
                }
            }
        }


    /**
     * Save the user model with the current property values
     *
     * @return boolean True if the user was saved, false otherwise
     */

        public function saveUserToDB()
        {

            $this->validate();

            if (empty($this->errors))
            {
                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                
                $token = new Token();

                $hashed_token = $token->getHash();
                $this->activation_token = $token->getValue();

                $sql = 'INSERT INTO users (username, email, password_hash, activation_hash_token)
                        VALUES (:username, :email, :password_hash, :activation_token)';
            
                $db = static::getDBConnection();
                $stmt = $db->prepare($sql);
            
                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
                $stmt->bindValue(':activation_token', $hashed_token, PDO::PARAM_STR);
            
                return $stmt->execute();
            }

            return false;
        }

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */


        public static function emailExists($email, $existing_user_id = null)
        {
            $user = static::findUserByEmail($email);
    
            if ($user) {
                if ($user->id != $existing_user_id) {
                    return true;
                }
            }
    
            return false;
        }

    /**
     * See if a user record already exists with the specified username
     *
     * @param string $username username address to search for
     *
     * @return boolean  True if a record already exists with the specified username, false otherwise
     */
        
        public static function usernameExists($username, $existing_user_id = null)
        {
            $user = static::findUserByUsername($username);

            if($user){
                if($user->id != $existing_user_id){
                    return true;
                }
            }

            return false;
        }

        

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */

        public static function findUserByEmail($email)
        {
            $sql = 'SELECT * FROM users 
            WHERE email = :email';
    
            $db = static::getDBConnection();

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();
    
            return $stmt->fetch();
        }
    
    /**
     * Find a user model by username
     *
     * @param string $username username to search for
     *
     * @return mixed User object if found, false otherwise
     */

        public static function findUserByUsername($username)
        {
            $sql = 'SELECT * FROM users
            WHERE username = :username';

            $db = static::getDBConnection();

            $stmt = $db -> prepare($sql);

            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetch();
        }

    /**
     * Authenticate a user by email and password. User account has to be active.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */

        public static function authenticate($email, $password)
        {
            $user = static::findUserByEmail($email);
    
            if ($user && $user->is_active) {
                if (password_verify($password, $user->password_hash)) {
                    return $user;
                }
            }
    
            return false;
        }

     /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */

        public static function findUserByID($id)
        {
            $sql = 'SELECT * FROM users WHERE id = :id';
    
            $db = static::getDBConnection();

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    
            $stmt->execute();
    
            return $stmt->fetch();
        }


    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */

        public function rememberLogin(){

            $token = new Token();
            $hashed_token = $token->getHash();

            $this->remember_token = $token->getValue();
            $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now

            $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                    VALUES (:token_hash, :user_id, :expires_at)';

            $db = static::getDBConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

            return $stmt->execute();
        }

    /**
     * Send password reset instructions to the user specified
     *
     * @param string $email The email address
     *
     * @return void
     */

        public static function sendPasswordReset($email)
        {
            $user = static::findUserByEmail($email);
    
            if ($user) {
    
                if ($user->startPasswordReset()) {
    
                    $user->sendPasswordResetEmail();
    
                }
            }
        }


    /**
     * Start the password reset process by generating a new token and expiry
     *
     * @return void
     */

        protected function startPasswordReset(){

            $token = new Token();
            $hashed_token = $token->getHash();
            $this->password_reset_token = $token->getValue();

            $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

            $sql = 'UPDATE users
                    SET password_reset_hash = :token_hash,
                        password_reset_expires_at = :expires_at
                    WHERE id = :id';

            $db = static::getDBConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

    /**
     * Send password reset instructions in an email to the user
     *
     * @return void
     */
    
        protected function sendPasswordResetEmail(){

            $url = 'https://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;
    
            $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
            $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);
    
            Mail::send($this->email, 'Password reset', $text, $html);
        }

    /**
     * Find a user model by password reset token and expiry
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */

        public static function findUserByPasswordReset($token){

            $token = new Token($token);
            $hashed_token = $token->getHash();

            $sql = 'SELECT * FROM users
                    WHERE password_reset_hash = :token_hash';

            $db = static::getDBConnection();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            $user = $stmt->fetch();

            if ($user) {

                // Check password reset token hasn't expired
                if (strtotime($user->password_reset_expires_at) > time()) {

                    return $user;
                }
            }
        }

    /**
     * Reset the password
     *
     * @param string $password The new password
     *
     * @return boolean  True if the password was updated successfully, false otherwise
     */

        public function resetPassword($password){

            $this->password = $password;
    
            $this->validate();
    
            if (empty($this->errors)) {
    
                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    
                $sql = 'UPDATE users
                        SET password_hash = :password_hash,
                            password_reset_hash = NULL,
                            password_reset_expires_at = NULL
                        WHERE id = :id';
    
                $db = static::getDBConnection();
                $stmt = $db->prepare($sql);
    
                $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    
                return $stmt->execute();
            }
    
            return false;
        }

    /**
     * Send an email to the user containing the activation link
     *
     * @return void
     */

        public function sendActivationEmail()
        {
            $url = 'https://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;
    
            $text = View::getTemplate('Signup/activation_email.txt', ['url' => $url]);
            $html = View::getTemplate('Signup/activation_email.html', ['url' => $url]);
    
            Mail::send($this->email, 'Account activation', $text, $html);
        }

    /**
     * Activate the user account with the specified activation token
     *
     * @param string $value Activation token from the URL
     *
     * @return void
     */

        public static function activateAccount($value){

            $token = new Token($value);
            $hashed_token = $token->getHash();
    
            $sql = 'UPDATE users
                    SET is_active = 1,
                        activation_hash_token = null
                    WHERE activation_hash_token = :hashed_token';
    
            $db = static::getDBConnection();
            $stmt = $db->prepare($sql);
    
            $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
    
            $stmt->execute();                
        }



        public function editUsername(){

            $this->validate();

            $user = static::findUserByID($_SESSION['user_id']);

            if($user){

                if (empty($this->errors)) {

                    $sql = 'UPDATE users
                            SET username = :newUsername
                            WHERE id = :id';

                    $db = static::getDBConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(':newUsername', $this->username, PDO::PARAM_STR);
                    $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

                    return $stmt->execute();
                }
        }

            return false;
        }


        public function editEmail()
        {
            $this->validate();

            $user = static::findUserByID($_SESSION['user_id']);

            if($user) {

                if (empty($this->errors)) {

                    $sql = 'UPDATE users
                            SET email = :email
                            WHERE id = :id';

                    $db = static::getDBConnection();

                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                    $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

                    return $stmt->execute();
                }

            }
        }


    /**
     * Authenticate a user by password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */

    public static function authenticatePassword($password, $userId)
    {
        $user = static::findUserById($_SESSION['user_id']);

        if ($user && $user->is_active) {
            if (password_verify($password, $user->password_hash)) {
                return true;
            }
        }else{
            $this->errors['errorConfirmPassword'] = 'Enter the correct current password';
        }

        
    }

    

        public function editPassword()
        {
            $this->validate();


            $is_valid = static::authenticatePassword($this->oldPassword, $_SESSION['user_id'] );
            
            if(empty($this->errors) && $is_valid){

                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    
                $sql = 'UPDATE users
                        SET password_hash = :password_hash,
                            password_reset_hash = NULL,
                            password_reset_expires_at = NULL
                        WHERE id = :id';
    
                $db = static::getDBConnection();
                $stmt = $db->prepare($sql);
    
                $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    
                return $stmt->execute();
            }
    
            return false;
        }



        

    /**
     * Update the user's profile
     *
     * @param array $data Data from the edit profile form
     *
     * @return boolean  True if the data was updated, false otherwise
     */

        public function updateProfile($data){

            $this->username = $data['username'];
            $this->email = $data['email'];

            // Only validate and update the password if a value provided
            if ($data['password'] != '') {
                $this->password = $data['password'];
            }

            $this->validate();

            if (empty($this->errors)) {

                $sql = 'UPDATE users
                        SET username = :username,
                            email = :email';

                // Add password if it's set
                if (isset($this->password)) {
                    $sql .= ', password_hash = :password_hash';
                }

                $sql .= "\nWHERE id = :id";

                $db = static::getDBConnection();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

                // Add password if it's set
                if (isset($this->password)) {
                    $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
                }

                return $stmt->execute();
            }

            return false;
        }

  }




