
<?php

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

$username='mhannah';

     $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
     // $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
   // foreach($dbh->query("select * from users where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
      foreach($dbh->query("select * from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        //print_r($row);
        $users_id = $row['users_id'];
        $fname= $row['users_fname'];
       $lname= $row['users_lname'];
       $team = $row['team_name'];
     
    }
  $sql = "select expected_outcome, assessment_id from assessment where users_id = '$users_id' AND ReAssessment='1'";   
      
   $reassess = $dbh->query($sql);
   $row = $reassess->fetch();
   echo $row;

 ?>
 
 <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Build</title>
</head>
<body>
<h1>GHC Assessment</h1>

<h2>Unit:  <? echo $team;?></h2>
<br>
<br>
<h3>Name  <? echo $fname . " " . $lname;?></h3>

<br>
<br>

<?

  if(!$row) { 
    
    echo "No Reassessment!!";
 }
 else {
 	
 		echo "<h3>Reassessment</h3>";	
 	foreach($dbh->query($sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
{
?>
		<a href='reassess.php?id=<? echo $row["assessment_id"]; ?>'><? echo $row['expected_outcome']; ?></a><?
		

	echo "<br>";
	        //print_r($reassess_row);
 
}
 }
?>
 
 

</body>
</html>