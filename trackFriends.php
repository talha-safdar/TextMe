<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
if (isset($_SESSION['user_ID'])) // check if user is logged in
{
    $view = new stdClass(); // stdClass object instantiated
    $view->pageTitle = 'TextMe - Track Friends'; // page title
    $_SESSION['mlml'] = "/API/maps/application/OpenLayers.js"; // try use this better to reduce hard coding
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated
    $view->userDataSet = $userDataSet->allFriends();
    require_once('Views/trackFriends.php'); // access to friends.php once
}
else
{
    header('location: index.php'); // redirect to index.php
}