<?php


// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

//WebDev server hostname
//$dbhost = 'localhost';
//$dbuser = $wwwuser;
//$dbpass = $wwwpass;

//Set DB name
//$dbname3 = 'assessment_2';

// Create PDO Connection object
   // $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);

/*
try {
	
	   $dbh = new PDO('mysql:host=localhost;dbname=assessment', $wwwuser, $wwwpass);
    //$dbh = new PDO('mysql:host=localhost;Assessment_2=test', $user, $pass);
    foreach($dbh->query('SELECT * from user') as $row) 
    {
    	print_r($row);
    //$getusercount =$dbh->query("SELECT * FROM users where users_usersname=mhannah");
    //echo $usercount =$getusercount->rowCount();	
    //echo $getusercount['users_usersname'];
    //echo "this";
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
*/


//require 'class.Address.inc';

echo '<h2>Instantiating Address</h2>';
$address = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');

echo '<h2>Empty Address</h2>';
echo '<tt><pre>/'. var_export($address,TRUE). '</pre></tt>';


?>