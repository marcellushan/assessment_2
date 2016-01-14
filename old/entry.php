<?php
// Set username
$username = "mhannah";

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

//WebDev server hostname
$dbhost = 'localhost';
$dbuser = $wwwuser;
$dbpass = $wwwpass;


// Create PDO Connection object
    $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);

 $getusercount =$dbh->query("SELECT users_id FROM users where users_usersname='mhannah'");
    echo $usercount =$getusercount->rowCount();	
    echo "this";
//$usercount =$getusercount->rowCount();	
echo $getusercount;
?>