<?php
/**
 * To update friends on the map
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
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/UserDataSet.php");
    $location = [];
    $jsonEncode = "";
    if (isset($_SESSION['user_ID']))
    {
        $userDataSet = new UserDataSet(); // UserDataSet object instantiated
        $userDataSet = $userDataSet->allFriends(); // get all friends
        foreach ($userDataSet as $friend)
        {
            array_push($location, $friend->jsonSerialize()); // JSON serialise each element in the array and add to new array
        }
    }
    $jsonEncode = json_encode($location); // JSON encode
    print_r($jsonEncode); // output result
}
else
{
    header("location: ../index.php"); // redirect to homepage
}