<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
require_once('Models/UsersDataSet.php'); // access to UsersDataSet.php class once
$view->pageTitle = 'TextMe - Login'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
require_once('Views/index.php'); // access to login.php once