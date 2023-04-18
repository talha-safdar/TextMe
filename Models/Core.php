<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('UsersDataSet.php'); // access UserDataSet.php once
/*
 * The class Core extends class UsersDataSet. 
 * It acts as a means between the View and the Controller.
 * Every interaction from the user will go through this class,
 * conditional statements direct the input to the appropriate method
 * in the super class.
 */
Class Core extends UsersDataSet // extend the class UserDataSet
{
    public function __construct() // construct the object Core
    {
        parent::__construct(); // call superclass' constructor

        if (isset($_POST['register'])) // if register
        {
            parent::register(); // call superclass' method
        }
        else if (isset($_POST['login'])) // if login
        {
            parent::login(); // call superclass' method
        }
        else if (isset($_POST['uploadImage'])) // if upload image
        {
            parent::uploadImage(); // call superclass' method
        }
        else if (isset($_GET['exit'])) // if logout
        {
            parent::logout(); // call superclass' method
        }
        else if (isset($_POST['search'])) // is search
        {
            parent::searchBoxProcess(); // call superclass' method
        }
        else if (isset($_GET['user_ID_details'])) // if view details about a user
        {
            parent::userDetails(); // call superclass' method
        }
        else if (isset($_GET['sendRequest'])) // if send request to a user
        {
            parent::sendRequest(); // call superclass' method
        }
        else if (isset($_GET['profile'])) // if view profile
        {
            parent::profile(); // call superclass' method
        }
        else if (isset($_GET['requests'])) // if view request list
        {
            parent::requests(); // call superclass' method
        }
        else if (isset($_GET['acceptRequest'])) // if accept request
        {
            parent::acceptRequest(); // call superclass' method
        }
        else if (isset($_GET['refuseRequest'])) // if refuse request
        {
            parent::refuseRequest(); // call superclass' method
        }
        else if (isset($_GET['friends'])) // if view friend list
        {
            parent::friends(); // call superclass' method
        }
        else if (isset($_POST['filterSearch'])) // if filter search
        {
            parent::filterSearch(); // call superclass' method
        }
        else if (isset($_GET['requestsSent'])) // if view requests sent
        {
            parent::requestsSent(); // call superclass' method
        }
        else if (isset($_GET['cancelRequest'])) // if cancel request
        {
            parent::cancelRequest(); // call superclass' method
        }
        else if (isset($_GET['removeFriend'])) // if remove a friend
        {
            parent::removeFriend(); // call superclass' method
        }
        else if (isset($_GET['blockFriend'])) // if block a friend
        {
            parent::blockFriend(); // call superclass' method
        }
        else if (isset($_GET['trackFriends'])) // if block a friend
        {
            parent::trackFriends(); // call superclass' method
        }
    }
}
$in = new Core; // instantiate Core object
exit(); // exit the script