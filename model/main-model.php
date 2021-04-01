<?php

/* 
 * Main PHPMotors Model
 */

function getClassifications() {
    // create a connection using the connection function
    $db = phpmotorsConnect();
    // the SQL statement to be used with the database
    $sql = 'SELECT classificationName, classificationId FROM carclassification
    ORDER BY classificationName ASC';
    // create a prepared statement using the DB connection
    $stmt = $db->prepare($sql);
    // run the prepared statement
    $stmt->execute();
    // get data from DB and store as an array in variable
    $classifications = $stmt->fetchAll();
    // closes the DB interaction
    $stmt->closeCursor();
    // send the array back to where it was called
    return $classifications;
}

?>