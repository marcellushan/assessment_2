<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

//Assign the assessment_id variable from the id url paranmeter
$assessment_id = $_GET["id"];

//check for url values
if(@$_GET['team_name']) 
	{
		$team_name=$_GET['team_name'];
		$team_id=$_GET['team_id'];
		$team_type=$_GET['team_type'];
	}
	else 
	{
		//Assign the team info from the session variables
		$team_name=$_SESSION['team_name'];
		$team_id=$_SESSION['team_id'];
		$team_type=$_SESSION['team_type'];
	}

//use the team_type session variable to determine the SQL string
if($team_type==1) 
	{
		 $sql = "select * from assessment, goals, users where assessment.assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.user_id=users.user_id";
 	}
 	else
 	 {
 		$sql = "select * from assessment, goals,slo, users where assessment.assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id";
	}	
foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
	{
		$goal_id = $row['goals_id'];       
		 $goal = $row['goals_goal'];
		  $expected_outcome = $row['expected_outcome'];
		  $outcome_assessment= $row['outcome_assessment'];
		  $performance_targets= $row['performance_targets'];
		  $full_name=$row['user_fname'] . " " . $row['user_lname'];
		  $course=$row['course'];
		  $slo_id= $row['slo_id'];
		  @$slo_text= $row['slo_text'];
    }

 ?>
             <div class="well">
            <h1>Saved Assessment</h1>
            <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Last Editted by: <? echo $full_name; ?> </h3>
<br>
<br>
<form  action="confirm_saved.php?id=<? echo $assessment_id ?>" method="post">
<button type="submit">Save Assessment</button><p>
<a href="index.php" >Return to Home</a><p>
<h2>College Goal</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal ?></h4></td></tr></table>
<br>
<br>
<?
if($team_type==1) 
	{ ?>
<h2>Expected Outcome</h2>
<textarea rows="10" cols="100" name="expected_outcome" required ><? echo $expected_outcome ?></textarea>
<br>
<? }
else 
{ ?>
	<h2>Course Being Assessed</h2>
			<table border='1'><tr><td height="50px" width="700px" valign="top"><h3><? echo $course ?></h3></td></tr></table>
	<h2>Student Learning Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $slo_text; ?></h4></td></tr></table>
<? }  ?>
<br>
<br>
<h2>Outcome Assessment</h2>
<textarea rows="10" cols="100" name="outcome_assessment" required><? echo $outcome_assessment ?></textarea>
<br>
<h2>Performance Target</h2>
<textarea rows="10" cols="100" name="performance_targets" required><? echo $performance_targets ?></textarea>
<input type="hidden" name="goal_id" value="<? echo $goal_id ?>">
<input type="hidden" name="goal" value="<? echo $goal ?>">
<input type="hidden" name="slo_id" value="<? echo $slo_id ?>">
<input type="hidden" name="slo_text" value="<? echo $slo_text ?>">
<input type="hidden" name="course" value="<? echo $course ?>">
<br>
<button type="submit">Save Assessment</button>
</form>    
</div>
         </div>  <!-- container  -->  
<!-- Validation script  -->
         <script> $.validate(); </script>  
</html>