<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Vehicle Management Page</title>
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
            <div class="vehicle-management">
                <h1>Vehicle Management</h1>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <ul>
                    <li><a id="add-classification" href="/phpmotors/vehicles/index.php?action=add-classification" title='Add Classification'>-> Add Classification</a></li>
                    <li><a id="add-vehicle" href="/phpmotors/vehicles/index.php?action=add-vehicle" title='Add Vehicle'>-> Add Vehicle</a></li>
                </ul>
            </div>


            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($classificationList)) {
                echo '<h2>Vehicles By Classification</h2>';
                echo '<p>Choose a classification to see those vehicles</p>';
                echo $classificationList;
            }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>

        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->

    <!-- link to JavaScript file -->
    <script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>