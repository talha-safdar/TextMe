<?php
/**
 * To update the longitude and latitude dynamically
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
    $pass = new UserDataSet(); // instantiate UserDataSet
    $location = $_REQUEST['location'];
    $latAndLon = explode(" ", $location);
    $longitude = $latAndLon[0]; // longitude
    $latitude = $latAndLon[1]; // latitude
    $pass->setLatLong($latitude, $longitude); // upload to the database
    echo "lonLat updated";
}
else
{
    header("location: ../index.php"); // redirect to homepage
}