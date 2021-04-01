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
    <title>PHP Motors Admin Login Page</title>
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
            <h1>
                <?php
                echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'];
                ?>
            </h1>

            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>

            <p>You are logged in.</p>

            <div class="adminList">
                <ul>
                    <li>First name: <?php
                                    echo $_SESSION['clientData']['clientFirstname'];
                                    ?>
                    </li>
                    <li>Last name: <?php
                                    echo $_SESSION['clientData']['clientLastname'];
                                    ?>
                    </li>
                    <li>Email: <?php
                                echo $_SESSION['clientData']['clientEmail'];
                                ?>
                    </li>
                </ul>
            </div>

            <h2>Account Management</h2>
            <p>Use this link to update account information.</p>
            <a id="update-account" href="/phpmotors/accounts/index.php?action=update-account" title='Update Account'>Update Account Information</a>
            <br>

            <!-- only high level users can manage vehicles -->
            <div>
                <?php
                if ($_SESSION['clientData']['clientLevel'] > 1) {
                    echo "<h2>Inventory Management</h2>";
                    echo "<p>Use this link to manage the inventory.</p>";
                    echo "<a id='vehicle-management' href='/phpmotors/accounts/index.php?action=vehicle-management' title='Vehicle Management'>Vehicle Management</a>";
                }
                ?>
            </div>
            <div>
                <h2>Manage Your Product Reviews</h2>
                <?php
                // echo $clientFullname;
                // echo var_dump($_SESSION['clientData']['clientId']); // for testing purpose
                if (isset($_SESSION['clientReviewList'])) {
                    echo $_SESSION['clientReviewList'];
                }
                ?>
            </div>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->
</body>

</html>