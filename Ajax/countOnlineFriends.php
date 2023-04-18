<?php
/**
 * To count the number of all friends dynamically
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
    require_once ('../Models/UserDataSet.php');
    $count = new UserDataSet(); // instantiate UserDataSet
    echo $count->allFriendsAjax(); // count friend numbers
}
else
{
    header("location: ../index.php"); // redirect to homepage
}