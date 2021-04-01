<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Registration Page</title>
    <link href="/phpmotors/css/templateStyle.css" type="text/css" rel="stylesheet" media="screen">
    <link rel="preconnect" href="https://fonts.gstatic.com" media="screen">
    <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet" media="screen">
</head>

<body>
    <div id="wrapper">
        <header>
            <?php
            echo $myAccountLink;
            require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
            ?>
        </header>
        <nav>
            <?php
            // require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php';
            echo $navList;
            ?>
        </nav>
        <main>
            <div class="registerForm">
                <h1>Create Your Account</h1>
                
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>

                <form action="/phpmotors/accounts/index.php" method="post">
                    <label for="RegisFname">First Name</label><br>
                    <input type="text" id="RegisFname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required><br>
                    <label for="RegisLname">Last Name</label><br>
                    <input type="text" id="RegisLname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required><br>
                    <label for="RegisEmail">Email Address</label><br>
                    <input type="email" id="RegisEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br>
                    <label for="RegisPassword">Password</label><br>
                    <span style="color:blue;">(At least 8 characters with 1 number, 1 uppercase, and 1 special character)</span><br>
                    <input type="password" id="RegisPassword" name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br>
                    <!-- <button type="button" id="registerButton">Create Account</button><br> -->
                    <input type="submit" name="submit" value="Register" id="registerButton">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="register">
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