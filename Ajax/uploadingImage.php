<?php
/**
 * To upload the image dynamically
 */
require_once ('../Models/UsersDataSet.php');
$call = new UsersDataSet();
$token = "";
$filename = "";
$photo = "";
if(isset($_SESSION['ajaxToken'])) // check if session is set
{
    $token = $_SESSION['ajaxToken']; // assign to local variable
}
if (isset($_GET['token']) && $_GET['token'] == $token) // check if authorised access
{
    $filename = $_FILES['file']['tmp_name']; // file
    if(move_uploaded_file($filename, '../images/users/'.$_SESSION['username'].'.jpg')) // move image to directory
    {
        $path = './images/temp/'.$_SESSION['username'].'.jpg';
        $call->uploadImageAjax($path); // upload image details to the database
    }
}
else
{
    header("location: ../index.php"); // redirect to homepage
}