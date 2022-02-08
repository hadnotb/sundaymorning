<?php 

namespace App\Framework;

class FlashBag {

    static private function sessionCheck(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    static private function initFlashBag(string $type)
    {
        self::sessionCheck();
        if (!array_key_exists('flash', $_SESSION) || is_null($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
    
        if (!array_key_exists($type, $_SESSION['flash']) || is_null($_SESSION['flash'][$type])) {
            $_SESSION['flash'][$type] = [];
        }
    }
    
    static public function addFlash(string $message, string $type = 'success')
    {
        self::initFlashBag($type);
        $_SESSION['flash'][$type][] = $message;
    }
    
    static public function fetchMessages(string $type)
    {
        self::initFlashBag($type);
        $messages = $_SESSION['flash'][$type];
        $_SESSION['flash'][$type] = null;
        return $messages;
    }
    
    static public function hasMessages(string $type)
    {
        self::initFlashBag($type);
        return count($_SESSION['flash'][$type]);
    }
}