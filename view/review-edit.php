<?php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Template Page</title>
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
            <h1>Review Edit Page</h1>
            <h1><?php echo $_SESSION['oneReviewData']['invMake'] . " " . $_SESSION['oneReviewData']['invModel']; ?> Review</h1>

            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>

            <p>Reviewed on <?php echo $_SESSION['oneReviewData']['reviewDate'] ?></p>
            <div>

                <form action="/phpmotors/reviews/index.php" method="post">
                    <label for="updateReviewText">Review Text</label><br>
                    <textarea id="updateReviewText" name="updateReviewText" required><?php if (isset($_SESSION['oneReviewData']['reviewText'])) {
                                                                                            echo $_SESSION['oneReviewData']['reviewText'];
                                                                                        } ?></textarea><br>
                    <input type="submit" name="submit" value="Update" id="signInButton"><br>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="reviewId" <?php if (isset($reviewId)) {
                                                                echo "value='$reviewId'";
                                                            } ?>>
                    <input type="hidden" name="action" value="edit-click">
                </form>
                <p>invId: <?php echo $reviewId ?></p>
            </div>

        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->
</body>

</html>