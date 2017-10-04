<?php
/**
 * A wrapper for the PHPass class
 */
namespace encryption;

class passwordTools {
    static function createHash($password) {
        $hasher = new \encryption\PasswordHash(8, FALSE);
        return $hasher->HashPassword($password);
    }
    
    static function checkHash($password, $hash) {
        $hasher = new \encryption\PasswordHash(8, FALSE);
        return $hasher->CheckPassword($password, $hash);
    }
}