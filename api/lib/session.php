<?php 
namespace Lib;
class Session {

    private $cookieTime;      
    public function __construct() { 
        @session_start(); 
        session_cache_limiter(false); 
        $this->cookieTime = strtotime('+30 days'); 
    } 
     
    public function set($name, $value) { 
        $_SESSION[$name] = $value; 
    } 
     
    public function setMulti($base, $key, $value) { 
        $_SESSION[$base][$key] = $value; 
    } 
    public function user() { 
        if (isset($_SESSION["user_data"])) { 
            return $_SESSION["user_data"]; 
        }else
        {
            return array();
        } 
    } 
    public function get($name) { 
        if (isset($_SESSION[$name])) { 
            return $_SESSION[$name]; 
        } 
    } 
    public function getAll() { 
        return $_SESSION;
    } 
     
    public function getMulti($base, $key) { 
        if (isset($_SESSION[$base][$key])) { 
            return $_SESSION[$base][$key]; 
        } 
    } 
     
    public function kill($name) { 
        unset($_SESSION[$name]); 
    } 
     
    public function killAll() { 
        session_destroy(); 
    } 
     
    public function setCookie($name, $value) { 
        setcookie($name, $value, $this->cookieTime); 
    } 
     
    public function getCookie($name) { 
        return $_COOKIE[$name]; 
    } 
     
    public function killCookie($name) { 
        setcookie($name, null); 
    }

}
?>