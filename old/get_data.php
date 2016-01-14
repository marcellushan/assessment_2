<?php

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

echo $username='mhannah';
/*
     //$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
      $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
   // foreach($dbh->query("select * from users where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
      foreach($dbh->query("select users_fname, users_lname, team_name, team_mission_statement from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        //print_r($row);
       echo $fname = $row['users_fname'];
       echo $lname= $row['users_lname'];
       echo $team = $row['team_name'];
       
    }
    
  */  
try {
       $conn = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
    //$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO assessment (users_id,assessment_period,goals_id,expected_outcome) 
    VALUES (:users_id, :assessment_period,:goals_id, :expected_outcome)");
    $stmt->bindParam(':users_id', $users_id);
    $stmt->bindParam(':assessment_period', $assessment_period);
     $stmt->bindParam(':goals_id', $goals_id);
    $stmt->bindParam(':expected_outcome', $expected_outcome);

    // insert a row
    $users_id = "2";
    $assessment_period = "2014";
    $goals_id = "1";
    $expected_outcome = "do it again";
    $stmt->execute();
/*
    // insert another row
    $firstname = "Mary";
    $lastname = "Moe";
    $email = "mary@example.com";
    $stmt->execute();

    // insert another row
    $firstname = "Julie";
    $lastname = "Dooley";
    $email = "julie@example.com";
    $stmt->execute();
*/
    echo "New records created successfully";
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
//echo $unit_team = $row['unit_team_name'];
?>