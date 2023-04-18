<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
error_reporting(0); // safe to use it because it is a created directory that works as expected
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
require_once('Models/UsersDataSet.php'); // access to UsersDataSet.php class once
if (isset($_SESSION['user_ID'])) // check if user is logged in
{
    $_SESSION['userSent'] = "normal";
    $_SESSION['blocked'] = false;
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - ' . $_SESSION['username']; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    $view->pageTitle = 'TextMe - by Talha Safdar'; // page title
    unset($_SESSION['searchText']); // unset global variable searchText
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated
    $usersDataSet = new UsersDataSet(); // UsersDataSet object instantiated
    //$view->userDataSet = $usersDataSet->notifyRequest(); // call method from UsersDataSet class
    $view->userDataSet = $userDataSet->fetchAllUsers(); // call method from UserDataSet class
    require_once('Views/loggedInPage.php'); // access to loggedInPage.php once
}
else
{
    header('location: index.php'); // redirect to index.php
}