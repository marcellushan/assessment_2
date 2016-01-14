<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

//Assign variables from session
$team_name=$_SESSION['team_name'];
$full_name=$_SESSION['full_name'];
$team_type=$_SESSION['team_type'];
$team_id=$_SESSION['team_id'];

//Capture Assessment ID from url variable id
$assessment_id = $_GET["id"];

//Create today's date variable
$my_date = date("Y-m-d");

//Update record with Submit_date and submitted flag
$sql = "UPDATE assessment SET submitted='1', submit_date='$my_date' WHERE assessment_id = '$assessment_id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();


//If table is update send email to assessment admin
if($affected_rows==1) {
	send_mail($assessment_id,$full_name, $team_name, $team_type, $servername) ;
}

if($_SESSION['team_type']==1) 
	{
 		$select_sql = "select * from assessment, goals where assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id";
 	}
 	else {
 		$select_sql = "select * from assessment, goals,slo where assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id";
 }	

//Display record contents readonly
// $select_sql = "select * from assessment, goals, slo where assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id";   

 foreach($dbh->query($select_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
       $goal_text = $row['goals_goal'];
        $expected_outcome = $row['expected_outcome'];
        $outcome_assessment= $row['outcome_assessment'];
        $performance_targets= $row['performance_targets'];
        $slo_text=$row['slo_text'];
        $slo_num=$row['slo_num'];
        $team_id = $row['team_id'];
    }
   


 ?>
            ?>
          <html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=index.php?pickteam=<? echo $team_id ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>