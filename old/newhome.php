<html>

<?php



// Set Database user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh


//Set Username
echo $username='mhannah';


//Create Database object
$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);


//Join the users, team and user_team tables to get the users First Name, Last name, Team and Users ID
 foreach($dbh->query("select * from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        //print_r($row);
       $fname = $row['users_fname'];
        $lname= $row['users_lname'];
         $users_id = $row['users_id'];
       $team = $row['team_name'];
     
    }
   
   //SQL statement to determine in Reassessments are present from last year 
  //$reassess_sql = "select expected_outcome, assessment_id from assessment where users_id = '$users_id' AND ReAssessment='1'";   
    $saved_sql = "select expected_outcome, assessment_id from assessment where users_id = '$users_id' AND create_datetime IS NOT NULL";   
  
    //$reassess = $dbh->query("select * from assessment where reassessment = '1'");
    //$reassess = $dbh->query($sql);
   // echo $row_count = $reassess->rowCount();
   //echo $row = $reassess->fetch();
   
?>

<head>
<title>New Assessment Home Page</title>
</head>

<h1>GHC Assessment</h1>
<br>
<br>
<br>
<br>
<h2>Unit:  <? echo $team ?></h2>
<h2>Reported by:  <? echo $fname . " " . $lname ?></h2>
<br>
<br>
<br>
<br>
<?

  if(!$row) { 
    
    echo "No Reassessment!!";
 }
 else {
 	
 		echo "<h3>Reassessment</h3>";	
 	foreach($dbh->query($reassess_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
{
?>
		<a href='reassess.php?id=<? echo $row["assessment_id"]; ?>'><? echo $row['expected_outcome']; ?></a><?
		

	echo "<br>";
	        //print_r($reassess_row);
 
}
 }


<?

  if(!$row) { 
    
    echo "No Reassessment!!";
 }
 else {
 	
 		echo "<h3>Reassessment</h3>";	
 	foreach($dbh->query($reassess_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
{
?>
		<a href='reassess.php?id=<? echo $row["assessment_id"]; ?>'><? echo $row['expected_outcome']; ?></a><?
		

	echo "<br>";
	        //print_r($reassess_row);
 
}
 }


?>