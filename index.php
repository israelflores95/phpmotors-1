<?php
//this is the main controller
// Create or access a Session
session_start();

// get the database connetion file
require_once 'library/connections.php';
// get the main model for use as needed
require_once 'model/main-model.php';
// Get the functions library
require_once './library/functions.php';

// get the array of classifications from DB using model
$classifications = getClassifications();

// new way, create the nav bar in the functions.php which can be used by all controllers
$navList = createNavBar($classifications);

// build a navigation bar using the $classifications array => old way
// $navList = '<ul>';
// $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//     $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' 
//     title='View our $classification[classificationName] product line'>
//     $classification[classificationName]</a></li>";
// }
// $navList .= '</ul>';

$myAccountLink = '<a id="myAccount" href="./accounts/index.php?action=login" title="Login or Register with PHP Motors">My Account</a>';
$myLogoutLink = "<a id='myLogout' href='./accounts/index.php?action=logout' title='Log Out PHP Motors'>Log Out</a>";

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    case '500':
        include 'view/500.php'; // show the user the error message page if anything is broken (check connections.php)
        break;
    default:
        include 'view/home.php'; // default case must always be last
}

?>