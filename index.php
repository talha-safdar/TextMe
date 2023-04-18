<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
$view->pageTitle = 'TextMe'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
if(!isset($_SESSION['user_ID'])) // check if user is logged in
{
    $userDataSet = new UserDataSet(); // UserDataSet object instantiated#
    $view->pageTitle = 'TextMe - Guest'; // page title
    $_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
    unset($_SESSION['searchText']); // unset the global variable 'searchtext'
	$view->userDataSet = $userDataSet->fetchAllUsers(); // call method from UserDataSet
	require_once('Views/index.php'); // access to index.php once
} 

else
{
	header("location: ../loggedInPage.php"); // redirect to index.php
}