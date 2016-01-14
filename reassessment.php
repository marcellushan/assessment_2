<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

//Assign id
$reassessment=$_GET['id'];
$slo_id=$_GET['slo_id'];
$team_id=$_GET['team_id'];
$goals_id=$_GET['goals_id'];

//Pull Username, team_name, full_name and team_type from the SESSION
//$username=$_SESSION["username"];
$full_name=$_SESSION['full_name'];
$team_type=$_SESSION['team_type'];

//Assign the team_id from the pickteam url parameter
$team_id = $_GET['pickteam'];

//Join the users, team and user_team tables to get the mission_statement, team_name and user_id
$sql="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where te.team_id='$team_id' AND user_username='$username'";
 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
   		 {
         $mission = $row['team_mission_statement'];
         $user_id = $row['user_id'];
       $team_name = $row['team_name'];  
   		 }

	

 ?>
     <div class="well">
<h1 style="text-align:center;margin-left:auto;margin-right:auto;">Create
Assessment</h1>

  <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>

<p></p>

<!-- Insert the team mission statement  -->
<h3>Mission: <? echo $mission ?></h3>

<p></p>
</div>
 <div class="well">
 <form action="create_reassessment.php?id=<? echo $reassessment ?>" method="post">
 <input type="submit" value="Save Assessment"><p>
 <a href="index.php" >Return to Team Home</a><p>
 <h3>College Goal</h3>
<input type="hidden" name="team_id" value="<? echo $team_id ?>">
<input type="hidden" name="team_name" value="<? echo $team_name ?>">
 <?
 
 //If the team_type is Institutional (1) the load the goals from the database
 if($team_type==1) 
 {
 $goals_sql = "select * from goals where goals_id='$goals_id'";
 
 // Build the goals list
 foreach($dbh->query($goals_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    { ?>
  <input type="radio" name="goal" value="<? echo $row['goals_id']; ?>" required checked > <? echo $row['goals_goal']; ?><br>
	<? $label="Expected Outcome";
	}
}
else 

//If the team_type is Academic (0) then the goal is static and the SLOs are loaded from the database
{
echo $goal="<h4>Effect quality teaching and learning focused on academic achievement and personal and professional growth.</h4>";
?>
<input type="hidden" name="goal" value="1">
<?
$label="Student Learning Outcomes";
}
?>
</p>
<br>


<h3><? echo $label; ?></h3>
<? if($label=="Student Learning Outcomes") 
	{  

 	 	foreach($dbh->query("select * from slo where slo_id='$slo_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
  	 			{ ?>
  	 			<h4> <? echo $slorow['slo_text']; ?></h4>
  	 			<input type="hidden" name="slo_id" value="<? echo $slorow['slo_id']; ?>">
<? }
  	}
  	 else
  	  {
?>
<textarea rows="6" cols="100"  Name="expected_outcome" required><? echo $_GET['expected_outcome']; ?></textarea></p>
<? } ?>
<br>
<h3>Outcome Assessment Method</h3>

<textarea rows="6" cols="100"  Name="outcome_assessment" required></textarea></p>

<br>
<h3>Performance Targets</h3>

<textarea rows="6" cols="100"  Name="performance_targets" required></textarea></p>

<br>
<br>
 <input type="submit" value="Save Assessment"><p>
</form>
</div>
</div>
<script> $.validate(); </script>
</body>
</html>
