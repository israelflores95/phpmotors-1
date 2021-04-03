<?php
// this is the vehicle controller
// Create or access a Session
session_start();


// get the database connetion file
require_once '../library/connections.php';
// get the main model for use as needed
require_once '../model/main-model.php';
// get the vehicles model for use as needed
require_once '../model/vehicles-model.php';
// get the reviews model for use as needed
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';

// require_once '../uploads/index.php';


// get the array of classifications from DB using model
$classifications = getClassifications();

// new way, create the nav bar in the functions.php which can be used by all controllers
$navList = createNavBar($classifications);

// this is for the "Account" link to work in the header
$myAccountLink = '<a id="myAccount" href="../accounts/index.php?action=login" title="Login or Register with PHP Motors">My Account</a>';
$myLogoutLink = "<a id='myLogout' href='../accounts/index.php?action=logout' title='Log Out PHP Motors'>Log Out</a>";
// $selectedCar = $_POST['carClassification'];

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'new-classification':
        // Filter and store the data
        $newClassificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);

        // check for missing data
        if (empty($newClassificationName)) {
            $message = '<p style="color:red;">Please provide information for a new classification name.</p>';
            include '../view/add-classification.php';
            exit;
        }

        // Send the data to the model
        $classificationOutcome = addClassification($newClassificationName);

        // Check and report the result
        if ($classificationOutcome === 1) {
            // $message = "<p>Thanks for adding $newClassificationName</p>";
            // include '../view/vehicle-management.php'; // this is the old method
            header("Location: index.php?action=vehicle-management"); // use this to update the new classification name in the header right after clicking submit
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry $newClassificationName wasn't added successfully. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }
        break;
    case 'new-vehicle':

        // Filter and store the data
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);

        // Check for missing data
        if (
            empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) ||
            empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)
        ) {
            $message = '<p style="color:red;">Please provide information for all empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit;
        }

        // Send the data to the model
        $addVehicleOutcome = addVehicle(
            $invMake,
            $invModel,
            $invDescription,
            $invImage,
            $invThumbnail,
            $invPrice,
            $invStock,
            $invColor,
            $classificationId
        );

        // Check and report the result
        if ($addVehicleOutcome === 1) {
            $message = "<p style='color:green;'>Thanks for adding $invMake $invModel!</p>";
            include '../view/vehicle-management.php';
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry, the car $invMake $invModel wasn't added successfully. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;
    case 'vehicle-management':
        include '../view/vehicle-management.php';
        break;
    case 'add-classification':
        include '../view/add-classification.php';
        break;
    case 'add-vehicle':
        include '../view/add-vehicle.php';
        break;
        /* * ********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    * ********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':

        // primary key
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        // Filter and store the data
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);

        // Check for missing data
        if (
            empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) ||
            empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)
        ) {
            $message = '<p style="color:red;">Please provide information for all empty form fields.</p>';
            include '../view/vehicle-update.php';
            exit;
        }

        // Send the data to the model
        $updateResult = updateVehicle(
            $invId,
            $invMake,
            $invModel,
            $invDescription,
            $invImage,
            $invThumbnail,
            $invPrice,
            $invStock,
            $invColor,
            $classificationId
        );

        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            // $message = "<p style='color:green;'>Thanks for updating $invMake $invModel!</p>";
            // include '../view/vehicle-management.php';
            exit;
        } else {
            $message = "<p style='color:red;'>Sorry, the car $invMake $invModel wasn't updated successfully. Please try again.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);

        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }

        include '../view/classification.php';

        break;

    case 'specific-vehicle':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invInfo = getInvItemInfo($invId);
        $imgInfo = getImageInfo($invId); // get the image thumbnail

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }

        // if the user is logged in, we want to get the clientId
        if (isset($_SESSION['loggedin'])) {
            $clientId = $_SESSION['clientData']['clientId'];
            $clientName = substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'];
            $_SESSION['clientName'] = $clientName;

            $reviewForm = createReviewForm($clientName, $invId, $clientId);
        }

        // grab all the vehicle's data based on the id
        $specificVehicleReviewData = getSpecificVehicleReviews($invId);
        $reviewList = createReviewList($specificVehicleReviewData);
        $_SESSION['reviewList'] =  $reviewList;
       
        $specificVehicleThumbnail = displaySpecificVehicleThumbnail($imgInfo);
        $specificVehicle = displaySpecificVehicle($invInfo);
        $specificVehicleFullname = displaySpecificVehicleFullname($invInfo);

        $_SESSION['specificVehicleThumbnail'] = $specificVehicleThumbnail;
        $_SESSION['specificVehicle'] = $specificVehicle;

        include '../view/vehicle-detail.php';

        break;

    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-management.php';
}
