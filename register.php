<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
require_once('Models/UsersDataSet.php'); // access to UsersDataSet.php class once
$userDataSet = new UsersDataSet(); // UsersDataSet object instantiated
$view->pageTitle = 'TextMe - Registration'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
$view->userDataSet = $userDataSet->checkifHuman(); // call method from UsersDataSet
require_once('Views/register.php'); // access to register.php once