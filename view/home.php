<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Home Page</title>
    <link href="/phpmotors/css/hpStyle.css" type="text/css" rel="stylesheet" media="screen">
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

                echo "<span><a href = '/phpmotors/accounts' id='welcome-client'>Welcome " . $_SESSION['clientData']['clientFirstname'] . "</a></span>";
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
            <h2>Welcome to PHP Motors!</h2>
            <div class="car-intro-container">
                <div class="car-intro">
                    <p><strong>DMC Delorean</strong><br>3 Cup holders<br>Superman doors<br>Fuzzy dice!</p>
                </div>
                <img src="/phpmotors/images/delorean.jpg" alt="delorean car">
            </div>

            <img id="own-today" src="/phpmotors/images/site/own_today.png" alt="own today sign">

            <div class="reviews-section">
                <h2>DMC Delorean Reviews</h2>
                <ul>
                    <li>"So fast its almost like traveling in time." (4/5)</li>
                    <li>"Coolest ride on the road." (4/5)</li>
                    <li>"I'm feeling Marty McFly!" (5/5)</li>
                    <li>"The most futuristic ride of our day." (4.5/5)</li>
                    <li>"80's living and I love it!" (5/5)</li>
                </ul>
            </div>
            <div class="upgrades-section">
                <h2>Delorean Upgrades</h2>
                <div class="flex-container">
                    <div class="column">
                        <div class="upgrade-image"><img src="/phpmotors/images/upgrades/flux-cap.png" alt="flux capacitor"></div>
                        <a class="upgrade-link" href="#" title="flux capacitor">Flux Capacitor</a>
                        <div class="upgrade-image"><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper stickers"></div>
                        <a class="upgrade-link" href="#" title="bumper stickers">Bumper Stickers</a>
                    </div>

                    <div class="column">
                        <div class="upgrade-image"><img src="/phpmotors/images/upgrades/flame.jpg" alt="flame decals"></div>
                        <a class="upgrade-link" href="#" title="flame decals">Flame Decals</a>
                        <div class="upgrade-image"><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="hub caps"></div>
                        <a class="upgrade-link" href="#" title="hub caps">Hub Caps</a>
                    </div>
                </div>
            </div>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div> <!-- end of menu -->
</body>

</html>