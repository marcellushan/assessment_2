<?
include "inc/init.php"; 
include "inc/header.php"; 
include 'inc/validate.php';


//Assign variables from session
//$team_type=$_SESSION['team_type'];
//$team_name=$_SESSION['team_name'];
//$team_id=$_SESSION['team_id'];
$servername = $_SERVER['SERVER_NAME'];
//Capture Assessment Id from the URL
$assessment_id = $_GET["id"];
// $sql ="select * from assessment, goals,slo, users, team where assessment.assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.team_id=team.team_id";
 $sql = "SELECT * FROM team, assessment, users where assessment_id = '$assessment_id' and assessment.team_id=team.team_id and assessment.user_id=users.user_id";
 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
 	{
 			$team_type = $row['team_type'];
 			$username=$row['user_username'];
 			$team_id = $row['team_id'];
 	}
//exit(0);

// Set SQL statement based on team_type
if($team_type==1) 
	{
		$sql =  "select * from assessment, goals, users, team where assessment_id= '$assessment_id' AND assessment.user_id=users.user_id AND goals.goals_id=assessment.goals_id AND assessment.team_id=team.team_id"; 
 	}
 	else 
 	{
	$sql =  "select * from assessment, goals, slo, users, team  where assessment.assessment_id= $assessment_id AND assessment.user_id=users.user_id AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.team_id=team.team_id";
 	}

 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
	 {
		$goal = $row['goals_goal'];
		$expected_outcome = $row['expected_outcome'];
		$outcome_assessment= $row['outcome_assessment'];
		$performance_targets= $row['performance_targets'];
		$course=$row['course'];
		@$slo_text=$row['slo_text'];
		$submit_date = $row['submit_date'];
		$full_name=$row['user_fname'] . " " . $row['user_lname'];
		$team_name=$row['team_name'];
    }
// Create submit date
@$date = date_create($submit_date);	


 ?>
   <div class="well">         
            <h1>Submitted Assessment : Date <? echo date_format($date,"m/d/Y");  ?></h1>
                        		            <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>
<br>
<form action="rejected.php" method="get">
<h2>Administrator Comments</h2>

<textarea rows="6" cols="100"  Name="email_text" required></textarea></p>
<input type="hidden" name="team_type" value="<? echo $team_type ?>">
<input type="hidden" name="username" value="<? echo $username ?>">
<input type="hidden" name="id" value="<? echo $assessment_id ?>">
<input type="hidden" name="team_name" value="<? echo $team_name ?>">
<input type="hidden" name="team_id" value="<? echo $team_id ?>">

<input type="submit" name="submit" value="submit" />
</form>
<h2>College Goal</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal ?></h4></td></tr></table>

<div class="page-break"></div>
<?
if($_SESSION['team_type']==1) 
	{ ?>
<h2>Expected Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $expected_outcome ?></h4></td></tr></table>
<? }
else 
{ ?>
<h2>Course Being Assessed</h2>
			<table border='1'><tr><td height="50px" width="700px" valign="top"><h3><? echo $course ?></h3></td></tr></table>
	<h2>Student Learning Objective</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $slo_text ?></h4></td></tr></table>
<? }  ?>
<br>
<br>
<h2>Outcome Assessment Method</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $outcome_assessment ?></h4></td></tr></table>
<br>
<br>
<h2>Performance Target</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $performance_targets ?></h4></td></tr></table>
</div>
            </div>