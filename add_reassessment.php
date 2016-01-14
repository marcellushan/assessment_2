<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$my_date = date("Y-m-d");


$outcome_assessment = $_POST['outcome_assessment'];	
$performance_targets = $_POST['performance_targets'];	
$team_id = $_POST['team_id'];	
	$expected_outcome = $_POST['expected_outcome'];
	$goals_id=$_POST['goal'];	
if($_POST['expected_outcome']==1) 
	{
		$slo_id=$_POST['slo_id'];
		$sql = "INSERT INTO assessment (user_id, team_id, create_date, assessment_period, goals_id, slo_id, outcome_assessment,performance_targets ) VALUES ('70','$team_id','$my_date','2014', '1','$slo_id', '$outcome_assessment', '$performance_targets')";
	}
else 
	{
	$sql = "INSERT INTO assessment (user_id, team_id, create_date, assessment_period, goals_id, expected_outcome, outcome_assessment,performance_targets ) VALUES ('70','$team_id','$my_date','2014', '$goals_id','$expected_outcome', '$outcome_assessment', '$performance_targets')";
	}
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();
//grab the id of the new assessment and save it
$last_id = $dbh->lastInsertId();
$team_sql="SELECT * FROM assessment, team where assessment_id=$last_id AND assessment.team_id=team.team_id";
foreach($dbh->query($team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        $team_name=$row['team_name'];
    }


 ?>
          <html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=reassessment_admin.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
