<?php
/* 
 * Proxy connection to the phpmotors database
 */

function phpmotorsConnect() {

    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'iClient';
    $password = '57I5JdCPdTGuNY2P';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        // if(is_object($link)) {
        //     echo 'It worked';
        // }
        return $link;
    } catch(PDOException $e) {
        // echo "It didn't work, error: " . $e->getMessage();
        header('Location: /phpmotors/view/500.php');
        // header('Location: /phpmotors/index.php?action=500'); 
        // this method should work automatically when something is broken, but I don't know why it is not working
        exit;
    }
}

phpmotorsConnect();

?>