<?php
/*
 * Reviews Model
 */

// submit a new review
function submitReview($reviewText, $reviewDate, $invId, $clientId)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, reviewDate,invId, clientId)
        VALUES (:reviewText, :reviewDate, :invId, :clientId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function getSpecificVehicleReviews($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.reviewText, reviews.reviewDate, clients.clientFirstname, clients.clientLastname FROM reviews LEFT JOIN clients ON reviews.clientId = clients.clientId WHERE invId = :invId 
    ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $specificVehicleReviewData = $stmt->fetchAll(PDO::FETCH_ASSOC); // must use fetch all to grab all the data
    $stmt->closeCursor();
    return $specificVehicleReviewData;
}

function getAllReviewsByClient($clientId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.reviewDate, reviews.reviewId, inventory.invMake, inventory.invModel FROM reviews LEFT JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId 
    ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $specificClientReviewData = $stmt->fetchAll(PDO::FETCH_ASSOC); // must use fetch all to grab all the data
    $stmt->closeCursor();
    return $specificClientReviewData;
}

// get the data for one specific review
function getOneReviewInfo($reviewId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.reviewDate, reviews.reviewText, inventory.invMake, inventory.invModel FROM reviews LEFT JOIN inventory ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $oneReviewData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $oneReviewData;
}

function updateReview(
    $reviewId,
    $reviewText,
) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

function deleteReview($reviewId)
{
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
