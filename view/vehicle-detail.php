<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Vehicle <?php echo $invInfo['invMake']; ?> Detail Page</title>
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
            <p>You can find this vehicle's reviews at the bottom of the page.</p>
            <?php if (isset($message)) {
                echo $message;
            }
            ?>

            <?php
            if (isset($_SESSION['specificVehicleThumbnail'])) {
                echo $_SESSION['specificVehicleThumbnail'];
            } ?>

            <?php
            if (isset($_SESSION['specificVehicle'])) {
                echo $_SESSION['specificVehicle'];
            }
            ?>

            <hr>
            <div>
                <h1>Customer Reviews</h1>
                <!-- if the user is not logged in, show them the login link for them to login -->
                <?php
                if (!isset($_SESSION['loggedin'])) {
                    echo '<p>A review can be added by "logging in" </p>';
                    echo '<a href="../accounts/index.php?action=login">Click here to log in</a>';
                }
                ?>

                <?php
                if (isset($_SESSION['loggedin'])) {
                    if (isset($specificVehicle)) {
                        echo $specificVehicleFullname;
                    }
                }
                ?>

                <?php 
                if (isset($submitMessage)) {
                    echo $submitMessage;
                }
                ?>

                <?php if (isset($reviewForm)) {
                    echo $reviewForm;
                }
                ?>

            </div>

            <?php
            // echo var_dump($_SESSION['reviewList']); //this can be used for testing!
            if (isset($_SESSION['reviewList'])) {
                echo $_SESSION['reviewList'];
            }

            // $specificVehicleReviewData is the result we got by writing SQL code, if it is empty, that means there isn't any review for this vehicle. Therefore, display the message!
            if (empty($specificVehicleReviewData)) {
                echo '<p style="color: blue;">Be the first client to write the review!</p>';
            }
            ?>

        </main>

        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->
</body>

</html>