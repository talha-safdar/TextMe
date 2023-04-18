<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
require_once('Models/UserDataSet.php'); // access to UsersDataSet.php class once
$usersDataSet = new UserDataSet(); // UserDataSet object instantiated
$view->pageTitle = 'TextMe - User details'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
require_once('Views/userDetailsExtend.php'); // access to userDetailsExtend.php once