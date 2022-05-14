<?php

namespace App;

/**
 * Flash notification messages: messages for one-time display using the session
 * for storage between requests.
 *
 * PHP version 7.0
 */
class Flash
{
    /**
     * Add a message
     *
     * @param string $message  The message content
     *
     * @return void
     */
    public static function addMessage($message)
    {
        // Create array in the session if it doesn't already exist
        if (! isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }
 
        // Append the message to the array
        $_SESSION['flash_notifications'][] = $message;
    }
}

