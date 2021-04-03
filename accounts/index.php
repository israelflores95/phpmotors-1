<?php
//this is the accouts controller
// Create or access a Session
session_start();

// get the database connetion file
require_once '../library/connections.php';
// get the main model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';

// get the array of classifications from DB using model
$classifications = getClassifications();

// new way, create the nav bar in the functions.php which can be used by all controllers
$navList = createNavBar($classifications);

$registrationPageLink = "<a href='index.php?action=registration' title='Registration Page'>Not a member yet?</a>";
$myAccountLink = "<a id='myAccount' href='index.php?action=login' title='Login or Register with PHP Motors'>My Account</a>";
$myLogoutLink = "<a id='myLogout' href='index.php?action=logout' title='Log Out PHP Motors'>Log Out</a>";

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'register':
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail); // go to the functions.php to validate the email address
        $checkPassword = checkPassword($clientPassword); // go to the functions.php to validate the password, what is returned from the function is "1" if the password matches the format and a "0" (zero) if it doesn't.
        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $message = '<p style="color:red;" class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p style="color:red;">Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            // $message = "<p style='color:green;'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            // include '../view/login.php';
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }

        break;
    case 'login': // submit the form, we have this hidden in our login.php

        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);

        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        // grab all the customer reviews written by this user
        // $clientFullname = substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'];
        $clientId = $_SESSION['clientData']['clientId']; // get the clientId
        $specificClientReviewData = getAllReviewsByClient($clientId);
        $clientReviewList = createClientReviewList($specificClientReviewData);
        $_SESSION['clientReviewList'] =  $clientReviewList;


        // Send them to the admin view
        include '../view/admin.php';
        exit;

        break;
    case 'logout':
        session_unset();
        session_destroy();
        header("Location: /phpmotors/index.php");
        break;
    case 'registration':
        include '../view/registration.php';
        break;
    case 'Login':
        include '../view/login.php';
        break;

    case 'update-account':
        $clientId = $_SESSION['clientData']['clientId'];

        $accountInfo = getAccountItemInfo($clientId);
        if (count($accountInfo) < 1) {
            $message = 'Sorry, no account information could be found.';
        }
        include '../view/client-update.php';
        break;

    case 'update-click':

        // primary key
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_STRING);

        $clientEmail = checkEmail($clientEmail); // go to the functions.php to validate the email address

        if ($_SESSION['clientData']['clientEmail'] != $clientEmail) {
            $existingEmail = checkExistingEmail($clientEmail);

            // Check for existing email address in the table
            if ($existingEmail === 1) {
                $message = '<p style="color:red;" class="notice">That email address already exists. Do you want to login instead?</p>';
                include '../view/client-update.php';
                exit;
            }
        }

        // Check for missing data
        if (
            empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)
        ) {
            $message = '<p style="color:red;">Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit;
        }

        // Send the data to the model
        $updateResult = updateAccount(
            $clientId,
            $clientFirstname,
            $clientLastname,
            $clientEmail,
        );

        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p style='color:green;' class='notify'>Congratulations, user $clientFirstname $clientLastname was successfully updated.</p>";
            $_SESSION['message'] = $message;
            $_SESSION['clientData']['clientFirstname'] =  $clientFirstname;
            $_SESSION['clientData']['clientLastname'] =  $clientLastname;
            $_SESSION['clientData']['clientEmail'] =  $clientEmail;
            // header('location: /phpmotors/accounts/');
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry, the user $clientFirstname $clientLastname wasn't updated successfully. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        break;

    case 'password-update':

        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        // Filter and store the data
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        $checkPassword = checkPassword($clientPassword); // go to the functions.php to validate the password, what is returned from the function is "1" if the password matches the format and a "0" (zero) if it doesn't.

        // Check for missing data
        if (empty($checkPassword)) {
            $message = '<p style="color:red;">Please provide a valid password.</p>';
            include '../view/client-update.php';
            exit;
        }

        // Hash the checked password
        $clientPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $updateResult = updatePassword(
            $clientId,
            $clientPassword,
        );

        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p style='color:green;' class='notify'>Congratulations, password was successfully updated.</p>";
            $_SESSION['message'] = $message;
            // $_SESSION['clientData']['clientEmail'] =  $clientEmail;
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry, password wasn't updated successfully. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        break;

    default:
        $clientId = $_SESSION['clientData']['clientId']; // get the clientId
        $specificClientReviewData = getAllReviewsByClient($clientId);
        $clientReviewList = createClientReviewList($specificClientReviewData);
        $_SESSION['clientReviewList'] =  $clientReviewList;
        include '../view/admin.php'; // default case must always be last
}
