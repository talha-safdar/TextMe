<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Models/UsersDataSet.php'); // access to UsersDataSet.php class once
if (isset($_SESSION['user_ID'])) // check if user is logged in
{
    $_SESSION['userSent'] = "sent";
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - Requests sent list'; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated
    $view->userDataSet = $userDataSet->requestsSentUser(); // call method from UserDataSet class
    require_once('Views/requestsSent.php'); // access to requestsSent.php once
}
else
{
    header('location: index.php'); // redirect to index.php
}