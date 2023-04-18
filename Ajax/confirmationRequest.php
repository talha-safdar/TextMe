<?php
/**
 * To manage the friendship dynamically
 * accept or refuse requests, remove or block friends, cancel or send requests
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
    require_once ("../Models/UsersDataSet.php");
    $confirm = new UsersDataSet(); // instantiate UsersDataSet
    if ($_GET['confirm'] == 1 || $_GET['confirm'] == 2) // if accept request
    {
        echo $confirm->acceptRequestAjax($_GET['userID']);
    }
    else if ($_GET['confirm'] == 3 || $_GET['confirm'] == 4) // if refuse request
    {
        echo $confirm->refuseRequestAjax($_GET['userID']);
    }
    else if ($_GET['confirm'] == 5 || $_GET['confirm'] == 6) // if remove friend
    {
        echo $confirm->removeFriendAjax($_GET['userID']);
    }
    else if ($_GET['confirm'] == 7 || $_GET['confirm'] == 8) // if block friend
    {
        echo $confirm->blockFriendAjax($_GET['userID']);
    }
    else if ($_GET['confirm'] == 9 || $_GET['confirm'] == 10) // if cancel request
    {
        echo $confirm->cancelRequestAjax($_GET['userID']);
    }
    else if ($_GET['confirm'] == 11)                         // if send request
    {
        echo $confirm->sendRequestAjax($_GET['userID']);
    }
}
else
{
    header("location: ../index.php"); // redirect to homepage
}