<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
require_once('Models/UserDataSet.php'); // access to UserDataSet.php class once
$usersDataSet = new UserDataSet(); // UserDataSet object instantiated
$view->pageTitle = 'TextMe - User details'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
$view->usersDataSet = $usersDataSet->alreadyFriends(); // call method from UserDataSet class

// below loop to check if already sent the request
$_SESSION['alreadySent'] = false;
if(isset($_SESSION['checkIfGot']))
{
    if(array_key_exists(0, $_SESSION['checkIfGot']) && is_array($_SESSION['checkIfGot'][0]))
    {
        for ($i=0; $i<sizeof($_SESSION['checkIfGot'][0]); $i++)
        {
            if ($_SESSION['checkIfGot'][0][$i]["user_ID"] === (int)$_SESSION['got_user_ID'])
            {
                $_SESSION['alreadySent'] = true;
                break;
            }
        }
    }
}
else
{
    if ($_SESSION['checkIfGot'] === (int)$_SESSION['got_user_ID'])
    {
        $_SESSION['alreadySent'] = true;
    }
}

require_once('Views/userDetails.php'); // access to userDetails.php once