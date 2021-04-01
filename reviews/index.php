<?php
// this is the reviews controller

// Create or access a Session
session_start();

// get the database connetion file
require_once '../library/connections.php';
// get the main model for use as needed
require_once '../model/main-model.php';
// get the vehicles model for use as needed
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';


// get the array of classifications from DB using model
$classifications = getClassifications();
// new way, create the nav bar in the functions.php which can be used by all controllers
$navList = createNavBar($classifications);
$myAccountLink = '<a id="myAccount" href="../accounts/index.php?action=login" title="Login or Register with PHP Motors">My Account</a>';
$myLogoutLink = "<a id='myLogout' href='../accounts/index.php?action=logout' title='Log Out PHP Motors'>Log Out</a>";


$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'submit-review':
        // Filter and store the data
        $screenName = filter_input(INPUT_POST, 'screenName', FILTER_SANITIZE_STRING);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        date_default_timezone_set("America/Denver");
        $d = strtotime("now");
        $reviewDate = date("Y-m-d H:i:s", $d);
        
        // $pageInvId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if (empty($screenName) || empty($reviewText)) {
            $_SESSION['submitMessage'] = '<p style="color:red;">Please provide information for all empty form fields.</p>';
            include '../view/vehicle-detail.php';
            exit;
        }

        // Send the data to the model
        $submitReviewOutcome = submitReview($reviewText, $reviewDate, $invId, $clientId);

        // display the form again, so they can submit another review if they want
        $reviewForm = createReviewForm($screenName, $invId, $clientId);

        if ($submitReviewOutcome === 1) {
            // $_SESSION['submitMessage'] = "<p style='color:green;'>Thanks for the review. It is displayed below!</p>";
            $submitMessage = "<p style='color:green;'>Thanks for the review. It is displayed below!</p>";

            // grab all the vehicle's data based on the id
            $specificVehicleReviewData = getSpecificVehicleReviews($invId);
            $reviewList = createReviewList($specificVehicleReviewData);
            $_SESSION['reviewList'] =  $reviewList;

            // $specificVehicleReviewData = getSpecificVehicleReviews($invId);
            // $_SESSION['reviewData'] =  $specificVehicleReviewData;
            // $reviewList = createReviewList($specificVehicleReviewData);

            // $_SESSION['specificVehicleReviewData'] = $specificVehicleReviewData;

            include '../view/vehicle-detail.php';
            exit;
        } else {
            $_SESSION['submitMessage'] = "<p style='color:red;'>Sorry, the review submission failed. Please try again.</p>";
            include '../view/vehicle-detail.php';
            exit;
        }

        break;

    case 'edit-review':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT); // get the reviewId from functions.php
        $clientFullname = filter_input(INPUT_GET, 'clientFullname', FILTER_SANITIZE_STRING); // get the customer's fullname (first name initial + last name)
        $oneReviewData = getOneReviewInfo($reviewId);
        $_SESSION['oneReviewData'] = $oneReviewData;


        include '../view/review-edit.php';
        break;

    case 'delete-review':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT); // get the reviewId from functions.php
        $oneReviewData = getOneReviewInfo($reviewId);
        $_SESSION['oneReviewData'] = $oneReviewData;

        include '../view/review-delete.php';
        break;

    case 'edit-click':
        $reviewText = filter_input(INPUT_POST, 'updateReviewText', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if (empty($reviewText)) {
            $message = '<p style="color:red;">Please provide information for the review text.</p>';
            include '../view/review-edit.php';
            exit;
        }

        // Send the data to the model, will return the rowsChanged
        $updateReview = updateReview(
            $reviewId,
            $reviewText,
        );

        // Check and report the result
        if ($updateReview === 1) {
            $message = "<p style='color:green;' class='notify'>Congratulations, the review was successfully updated.</p>";
            $_SESSION['message'] = $message;
            // $_SESSION['clientData']['clientFirstname'] =  $clientFirstname;
            // $_SESSION['clientData']['clientLastname'] =  $clientLastname;
            // $_SESSION['clientData']['clientEmail'] =  $clientEmail;
            // header('location: /phpmotors/accounts/');
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry, the review wasn't updated successfully. Please try again.</p>";
            include '../view/review-edit.php';
            exit;
        }

        break;

    case 'delete-click':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $deleteResult = deleteReview($reviewId);

        if ($deleteResult) {
            $message = "<p style='color:green;'>Congratulations, the review was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            // include '../view/admin.php';
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p style='color:red;'>Error: the review was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            // include '../view/review-delete.php';
            exit;
        }

        break;

    default:
        include '../view/admin.php'; // default case must always be last
}
