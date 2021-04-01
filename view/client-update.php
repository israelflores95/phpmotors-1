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
    <title>PHP Motors Client Account Update Page</title>
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

        <main>
            <div class="updateAccountForm">
                <h1>Update Account Information</h1>
                <h2>Update Account Info</h2>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="/phpmotors/accounts/index.php" method="post">
                    <label for="updateAccountFname">First Name</label><br>
                    <input type="text" id="updateAccountFname" name="clientFirstname" <?php if (isset($clientFirstname)) {
                                                                                    echo "value='$clientFirstname'";
                                                                                } elseif (isset($accountInfo['clientFirstname'])) {
                                                                                    echo "value='$accountInfo[clientFirstname]'";
                                                                                } ?> required><br>
                    <label for="updateAccountLname">Last Name</label><br>
                    <input type="text" id="updateAccountLname" name="clientLastname" <?php if (isset($clientLastname)) {
                                                                                    echo "value='$clientLastname'";
                                                                                } elseif (isset($accountInfo['clientLastname'])) {
                                                                                    echo "value='$accountInfo[clientLastname]'";
                                                                                } ?> required><br>
                    <label for="updateAccountEmail">Email Address</label><br>
                    <input type="email" id="updateAccountEmail" name="clientEmail" <?php if (isset($clientEmail)) {
                                                                                echo "value='$clientEmail'";
                                                                            } elseif (isset($accountInfo['clientEmail'])) {
                                                                                echo "value='$accountInfo[clientEmail]'";
                                                                            } ?> required><br>

                    <input type="submit" name="submit" value="Update Info" id="updateAccountButton">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="update-click">
                    <input type="hidden" name="clientId" value="<?php if(isset($accountInfo['clientId'])){ echo $accountInfo['clientId'];} 
                    elseif(isset($clientId)){ echo $clientId; } ?>">
                </form>
            </div>

            <div class="updatePasswordForm">
                <h2>Update Password</h2>

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="/phpmotors/accounts/index.php" method="post">
                    <label for="RegisPassword">Password</label><br>
                    <span style="color:blue;">(At least 8 characters with 1 number, 1 uppercase, and 1 special character)</span><br>
                    <span>*note your original password will be changed.</span><br>
                    <input type="password" id="RegisPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br>
                    <!-- <button type="button" id="registerButton">Create Account</button><br> -->
                    <input type="submit" name="submit" value="Update Password" id="updatePasswordButton">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="password-update">
                    <input type="hidden" name="clientId" value="<?php if(isset($accountInfo['clientId'])){ echo $accountInfo['clientId'];} 
                    elseif(isset($clientId)){ echo $clientId; } ?>">
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