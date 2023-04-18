<?php
/**
 * To generate unique tokens
 */
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$token = substr(str_shuffle(MD5(microtime())), 0, 20); // generate token
echo $_SESSION['ajaxToken'] = $token; // assign to global variable and then echo