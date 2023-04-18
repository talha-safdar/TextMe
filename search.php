<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
$view = new stdClass(); // stdClass object instantiated
$view->pageTitle = 'TextMe - Search result'; // page title
$_SESSION['title'] = $view->pageTitle; // use variable 'title' to name the tab
require_once('Views/search.php'); // access to search.php once