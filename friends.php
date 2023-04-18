<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
if (isset($_SESSION['user_ID'])) // check if user is logged in
{
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - Friend list'; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    $_SESSION['userSent'] = "friend";
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated
    $view->userDataSet = $userDataSet->friendsUser();
    require_once('Views/friends.php'); // access to friends.php once
}
else
{
    header('location: index.php'); // redirect to index.php
}