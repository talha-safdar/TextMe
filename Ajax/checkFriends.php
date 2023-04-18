<?php
/**
 * To manage the buttons "Requests", "Sent", and "Friends"
 * if empty list then notify the user that the list is empty
 * e.g. click on "Requests" button -> "no Requests"
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
    $check = new UserDataSet(); // instantiate UserDataSet
    if($_GET['look'] == 1) // 1 = requests button
    {
        $count = $check->requestsUserAjax();
        if($count == 0)
        {
            echo 0; // none
        }
        else
        {
            echo 1; // more than zero
        }
    }
    else if($_GET['look'] == 2) // 2 = friends button
    {
        $count = $check->allFriendsAjax();
        if($count == 0)
        {
            echo 0; // none
        }
        else
        {
            echo 1; // more than zero
        }
    }
    else if($_GET['look'] == 3) // 3 = sent button
    {
        $count = $check->requestsSentUserAjax();
        if($count == 0)
        {
            echo 0; // none
        }
        else
        {
            echo 1; // more than zero
        }
    }
}
else
{
    header("location: ../index.php"); // redirect to homepage
}