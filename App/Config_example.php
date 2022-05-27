<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'your_Database_host';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'your_database_name';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'database_user';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'database_password';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY ='your_Secret_key_for_hashing';

    /**
     * Email (SMTP username)
     * @var string
     *
     */

     const SMTP_USERNAME = 'your_email'; 


    /**
     * Password (SMTP password)
     * @var string
     */

    const SMTP_PASSWORD = 'your_password_for_email';     
}
