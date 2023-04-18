<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Models/UsersDataSet.php');  // access to UsersDataSet.php class once
if (isset($_SESSION['user_ID'])) // check if user is logged in
{
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - Search result'; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    require_once('Views/searchLoggedIn.php');  // access to searchLoggedIn.php class once
}
else
{
    header('location: index.php'); // redirect to index.php
}