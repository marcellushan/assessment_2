<?php

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

echo $username='mhannah';
/*
try {
     //$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
      $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
    foreach($dbh->query("select * from users where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        // print_r($row);
    }
    //$dbh = null;
   
     $getuser = $dbh->query('SELECT * FROM users');
  $usercheck = $getuser->rowCount();
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

 //Check to see if user is in the users table
  $getuser = $dbh->query("SELECT * FROM users,");
  $usercheck = $getuser->rowCount();
  */
  echo "tat";
  
 
  //echo $getuser;
  
  
  
  //Display Username
  
// $getunits = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
?>