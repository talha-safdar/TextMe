<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
if (isset($_SESSION['user_ID']))
{
    $_SESSION['userSent'] = "request";
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - Request list'; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated
    $view->userDataSet = $userDataSet->requestsUser(); // call method from UserDataSet class
    require_once('Views/requests.php');// access to UsersDataSet.php once
}
else
{
    header('location: index.php'); // redirect to index.php
}