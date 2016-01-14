<?
include "inc/init.php"; 
include "inc/header.php"; 
include 'inc/validate.php';

//Assign variables from session
//$username=$_SESSION["username"];
$full_name=$_SESSION['full_name'];
$team_name=$_SESSION['team_name'];
$team_id=$_SESSION['team_id'];
$team_type=$_SESSION['team_type'];

//use username to get additional info from the user table
 $user_sql = "select * from users where user_username= '$username'";
 foreach($dbh->query($user_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
		$user_id = $row['user_id'];
		$fname= $row['user_fname'];
		$lname= $row['user_lname'];
		$full_name = $fname . " " . $lname;
    }


//Capture Assessment ID from url parameter
$assessment_id = $_GET["id"];

 
 //Assign variables from POST array
$goal_id = $_POST['goal_id'];	
$goal = $_POST['goal'];	
@$expected_outcome = $_POST['expected_outcome'];	
$outcome_assessment = $_POST['outcome_assessment'];
$performance_targets = $_POST['performance_targets'];	
$slo_id=$_POST['slo_id'];
$slo_text=$_POST['slo_text'];
$course=$_POST['course'];

//Update record in the Assessment table if data is changed
if($team_type==1) 
	{
		$sql = "UPDATE assessment SET goals_id='$goal_id', user_id='$user_id', expected_outcome='$expected_outcome', outcome_assessment='$outcome_assessment', performance_targets= '$performance_targets' WHERE assessment_id = '$assessment_id'";
	}
	else 
	{
		$sql = "UPDATE assessment SET goals_id='$goal_id',  user_id='$user_id', course='$course', outcome_assessment='$outcome_assessment', performance_targets= '$performance_targets' WHERE assessment_id = '$assessment_id'";
	}
	//echo $sql;
	//exit(0);
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();

 ?>
  <div class="well">          
      <h1>Assessment Confirmation</h1>
      <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
       <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>
<br>
<button type="button" onclick="final_submit(<? echo $assessment_id ?>);">Submit Assessment</button><p>
<?
//if user is a member of more than one team, create an additional link
 if($_SESSION['list']) 
	{ 
	?>
	  <a href="index.php" onclick="check_submit()">Return to Home</a><p>
	<?
	 }
	 ?>
	 <a href="Saved.php?id=<? echo $assessment_id ?>">Edit Assessment</a><p>

	  		<a href="index.php?pickteam=<? echo $team_id ?>" onclick="check_submit()">Return to Team Home</a><p>
<a href="assessment.php?pickteam=<? echo $team_id ?>" onclick="check_submit()">Create New Assessment</a><p>
<h2>College Goal</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal ?></h4></td></tr></table>
<br>
<? 
if($team_type==1) 
	{ ?>
<h2>Expected Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $expected_outcome ?></h4></td></tr></table>
<br>
<? }
else 
{ ?>
<h2>Course Being Assessed</h2>
			<table border='1'><tr><td height="50px" width="700px" valign="top"><h3><? echo $course ?></h3></td></tr></table>
	<h2>Student Learning Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $slo_text; ?></h4></td></tr></table>
<br>
<? }  ?>
<br>
<br>
<h2>Outcome Assessment</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $outcome_assessment ?></h4></td></tr></table>
<br>
<br>
<h2>Performance Target</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $performance_targets ?></h4></td></tr></table>
<br>
<button type="button" onclick="final_submit(<? echo $assessment_id ?>);">Submit Assessment</button><p>
</div> 

        </div> <!-- container -->
       </body>
    <html>
