<?php

namespace App;

/**
 * Unique random tokens
 *
 * PHP version 7.0
 */

 class Token 
 {
    /**
     * The token value
     * @var array
     */


    protected $token;

    /**
     * Class constructor. Create a new random token or assign an existing one if passed in.
     *
     * @param string $value (optional) A token value
     *
     * @return void
     */
    public function __construct()
    {
        
	    $this->token = bin2hex(random_bytes(16));  // 16 bytes = 128 bits = 32 hex characters
 
    }

 }