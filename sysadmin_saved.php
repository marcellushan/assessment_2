
<?

session_start();

include "inc/init.php"; 

include 'inc/validate.php';


//Capture Assessment ID from url parameter
$assessment_id = $_GET["id"];
$team_type=$_GET['team_type'];

 
 //Assign variables from POST array
$goal_id = $_POST['goal_id'];	
$goal = $_POST['goal'];	
$expected_outcome = $_POST['expected_outcome'];	
$outcome_assessment = $_POST['outcome_assessment'];
$performance_targets = $_POST['performance_targets'];	
$slo_id=$_POST['slo_id'];
$slo_text=$_POST['slo_text'];
$slo_num=$_POST['slo_num'];

//Update record in the Assessment table if data is changed
if($team_type==1) 
	{
		$sql = "UPDATE assessment SET goals_id='$goal_id', expected_outcome='$expected_outcome', outcome_assessment='$outcome_assessment', performance_targets= '$performance_targets' WHERE assessment_id = '$assessment_id'";
	}
	else 
	{
		$sql = "UPDATE assessment SET outcome_assessment='$outcome_assessment', performance_targets= '$performance_targets' WHERE assessment_id = '$assessment_id'";
	}
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();
?>

<html>
  <head>
    <title>IU Webmaster redirect</title>
    <? 
    if($team_type==1) 
    	{ ?>
    <META http-equiv="refresh" content="0;URL=admin_edit.php?id=<? echo $assessment_id ?>">
    <? }
    else
    { ?>
     <META http-equiv="refresh" content="0;URL=acad_edit.php?id=<? echo $assessment_id ?>">
   <?  }  ?>
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>

 