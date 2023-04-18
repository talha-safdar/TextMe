<?php
/**
 * To search for users in realtime
 * as the user types new list of most relevant users are shown
 */
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$q = $_REQUEST["q"]; // term
$hint = ""; // structure for the JSON
$token = "";
if(isset($_SESSION['ajaxToken'])) // check if session is set
{
    $token = $_SESSION['ajaxToken']; // assign to local variable
}
if ($q !== "" && isset($_GET['token']) && $_GET['token'] == $token) // check if authorised access
{
    require_once('../Models/UserDataSet.php');
    $getOutput = new UserDataSet(); // instantiate UserDataSet
    $suggested = $getOutput->searchBoxAjaxAlt(); // search for results
    foreach($suggested as $person) // foreach loop to check the matching elements
    {
        $name = $person['full_name'];
        if (stristr($q, substr($name, 0, strlen($q)))) // match
        {
            if ($hint === "")
            {
                $hint = "[" . json_encode($person);
            }
            else
            {
                $hint .= "," . json_encode($person);
            }
        }
    }
    if ($hint != "") $hint .= "]";
    echo $hint === "" ? "no suggestions" : $hint; // echo the result
}
else
{
    header("location: ../index.php"); // redirect to homepage
}