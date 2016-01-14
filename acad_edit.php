<?
include "inc/init.php"; 
include "inc/header.php"; 
include 'inc/validate.php';

//Assign the assessment_id variable from the id url paranmeter
$assessment_id = $_GET["id"];


//use the team_type session variable to determine the SQL string


 //$sql = "select * from assessment, goals,slo, user_assessment, users, team where assessment.assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id";
 $sql ="select * from assessment, goals,slo, users, team where assessment.assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id AND goals.goals_id=assessment.goals_id AND assessment.slo_id=slo.slo_id AND assessment.team_id=team.team_id";
foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
	{
		$goal_id = $row['goals_id'];       
		 $goal = $row['goals_goal'];
		 $team_name = $row['team_name'];
		 $team_type= $row['team_type'];
		 $course= $row['course'];
		  $expected_outcome = $row['expected_outcome'];
		  $outcome_assessment= $row['outcome_assessment'];
		  $performance_targets= $row['performance_targets'];
		  $full_name=$row['user_fname'] . " " . $row['user_lname'];
		  $slo_id= $row['slo_id'];
		  @$slo_num= $row['slo_num'];
		  $slo_text= $row['slo_text'];
    }


 ?>
             <div class="well">
            <h1>Saved Assessment</h1>
            <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Last Editted by: <? echo $full_name; ?> </h3>
<br>
<br>
<form  action="sysadmin_saved.php?id=<? echo $assessment_id ?>&team_type=0" method="post">
<button type="submit">Save Assessment</button><p>
	<button type="button" onclick="location.href='reject_assessment.php?id=<? echo $assessment_id ?>'">Reject Assessment</button><p>
	<button type="button" onclick="final_delete(<? echo $assessment_id ?>);">Delete Assessment</button><p>
<a href="report.php?admin=1" >Return to Report</a><p>
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
<input type="hidden" name="slo_num" value="<? echo $slo_num ?>">
<br>
<button type="submit">Save Assessment</button>
</form>    
</div>
<div class="well">
<a href="sysadmin_report.php"><h3>Return to Report Page</h3></a>
</div>
         </div>  <!-- container  -->  
<!-- Validation script  -->
         <script> $.validate(); </script>  
</html>
