<?php
/**
 * To set up own details for the map when clicking on the bubble
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
    $getImage = new UserDataSet(); // instantiate UserDataSet
    $infoUser = $getImage->profileUserAjax(); // profile
    // echo the details in HTML format
    echo $infoUser[0]->image == null ? '<div class="innerDetails"><a href="../Models/Core.php?user_ID_details=' . $infoUser[0]->user_ID . '">Profile</a></div><img class="mapsImage" height="50px" width="50px" src="../images/website/images/default.png">' : '<div class="innerDetails"><a href="../Models/Core.php?user_ID_details=' . $infoUser[0]->user_ID . '">Profile</a></div><img class="mapsImage" src="../images/users/' .  $infoUser[0]->image . '" height="50px" width="50px" alt="profile picture">';
}
else
{
    header("location: ../index.php"); // redirect to homepage
}