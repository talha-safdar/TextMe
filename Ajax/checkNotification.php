<?php
/**
 * To notify the user when a new requests have been received dynamically
 * check if requests list has more than one element and change tab name
 * e.g. (1) tab name
 */
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$token = "";
if(isset($_SESSION['ajaxToken'])) // check if session is set
{
    $token = $_SESSION['ajaxToken']; // assign to local variable
}
if (isset($_GET['token']) && $_GET['token'] == $token) // check if authorised access
{
    require_once ('../Models/UsersDataSet.php');
    $getNotification = new UsersDataSet(); // instantiate UsersDataSet
    echo $getNotification->requestsUserAjax() . "  " . $_SESSION['title']; // set up name for the tab
}
else
{
    header("location: ../index.php"); // redirect to homepage
}