<?php
/**
 * Validate and submit the login form dynamically
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
    $checkCredentials = new UsersDataSet(); // instantiate UsersDataSet
    $check = $checkCredentials->loginAjax($_GET['email'], $_GET['password']); // login process
    if ($check == true)
    {
        echo "0"; // it works
    }
    else
    {
        echo $check; // an error occurred
    }
}
else
{
    header("location: ../index.php"); // redirect to homepage
}