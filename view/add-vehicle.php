<?php
// Build the select list
$classificationList = '<select name="classificationId" required>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)) {
        if ($classification['classificationId'] === $classificationId) {
            $classificationList .= ' selected ';
        }
    }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>';
?>
<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Add Vehicle Page</title>
    <link href="/phpmotors/css/templateStyle.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="preconnect" href="https://fonts.gstatic.com" media="screen">
    <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet" media="screen">
</head>

<body>
    <div id="wrapper">
        <header>
            <?php
            if (isset($_SESSION['loggedin'])) {
                echo $myLogoutLink;
                require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';

                // echo "Welcome " . $_SESSION['clientData']['clientFirstname'];
                echo '<a href="../accounts/index.php">' . "Welcome " . $_SESSION['clientData']['clientFirstname'] . "</a>";
            } else {
                echo $myAccountLink;
                require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
            }
            ?>
        </header>
        <nav>
            <?php
            // require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php';
            echo $navList;
            ?>
        </nav>
        <main>
            <div class="addVehicleForm">
                <h1>Add Vehicle</h1>
                <p style="color:red;">*Note: All Fields Are Required</p>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="/phpmotors/vehicles/index.php" method="post">

                    <!-- <label for="carClassification">Choose Car Classification</label> -->
                    <!-- <select id="carClassification" name="carClassification"> -->
                    <span>Choose Car Classification</span>
                    <?php
                    // echo $dropdownList;
                    echo $classificationList;
                    ?>
                    <br><br>


                    <label for="invMake">Make</label><br>
                    <input type="text" id="invMake" name="invMake" <?php if (isset($invMake)) {
                                                                        echo "value='$invMake'";
                                                                    } ?> required><br>
                    <label for="invModel">Model</label><br>
                    <input type="text" id="invModel" name="invModel" <?php if (isset($invModel)) {
                                                                            echo "value='$invModel'";
                                                                        } ?> required><br>
                    <label for="invDescription">Description</label><br>
                    <textarea id="invDescription" name="invDescription" required><?php if (isset($invDescription)) {
                                                                                        echo $invDescription;
                                                                                    } ?></textarea><br>
                    <label for="invImage">Image Path</label><br>
                    <input type="text" id="invImage" name="invImage" <?php if (isset($invImage)) {
                                                                            echo "value='$invImage'";
                                                                        } ?> required><br>
                    <label for="invThumbnail">Thumbnail Path</label><br>
                    <input type="text" id="invThumbnail" name="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                                    echo "value='$invThumbnail'";
                                                                                } ?> required><br>
                    <label for="invPrice">Price</label><br>
                    <input type="number" id="invPrice" name="invPrice" <?php if (isset($invPrice)) {
                                                                            echo "value='$invPrice'";
                                                                        } ?> required><br>
                    <label for="invStock"># In Stock</label><br>
                    <input type="number" id="invStock" name="invStock" <?php if (isset($invStock)) {
                                                                            echo "value='$invStock'";
                                                                        } ?> required><br>
                    <label for="invColor">Color</label><br>
                    <input type="text" id="invColor" name="invColor" <?php if (isset($invColor)) {
                                                                            echo "value='$invColor'";
                                                                        } ?> required><br>
                    <input type="submit" name="submit" id="submit" value="submit">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="new-vehicle">
                    <!-- <input type="hidden" name="selectedCar" value="<php? $_POST['carClassification'] ?>"> -->
                </form>
            </div>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->
</body>

</html>