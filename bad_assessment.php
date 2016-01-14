<?
include "inc/init.php"; 

include 'inc/validate.php';

if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == FALSE && strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) 
	{
	$browser = "Safari";	
	}
	else 
	{
		$browser= "Other";
	}
//	echo $browser;


//Pull Username, team_name, full_name and team_type from the SESSION
$username=$_SESSION["username"];
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
  // bootstrap header   		
 include "inc/header.php"; 
 
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
 <? if($browser=="Safari") 
	 { ?>
	 <form name="myForm" action="save_assessment.php" onsubmit="return check()" method="post">
	 <? }
	 else 
	 { ?>
 <form action="assessment_saved.php" method="post">
 <? }?>
 <input type="submit" value="Save Assessment"><p>
 	  <a href="index.php" >Return to Team Home</a><p>
 <h3>College Goal</h3>
<input type="hidden" name="team_id" value="<? echo $team_id ?>">
<input type="hidden" name="team_name" value="<? echo $team_name ?>">
 <?
 
 //If the team_type is Admin (1) the load the goals from the database
 if($team_type==1) 
 {
  $goals_sql = "select * from goals where inactive='0'";
 
 // Build the goals list
 foreach($dbh->query($goals_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    { ?>
  <input type="radio" name="goal" value="<? echo $row['goals_id']; ?>" required> <? echo $row['goals_goal']; ?><br>
	<? 
// Set the label to Expected Outcome for Admin teams	
	$label="Expected Outcome";
	}
}
else 

//If the team_type is Academic (0) then the goal is static and the SLOs are loaded from the database
{
echo $goal="<h4>Effect quality teaching and learning focused on academic achievement and personal and professional growth.</h4>";
?>
<input type="hidden" name="goal" value="1">
<?

// Set the label to Student Learning Outcomes for Academic teams	
$label="Student Learning Outcomes";
}
?>
</p>
<br>


<h3><? echo $label; ?></h3>
<? if($label=="Student Learning Outcomes") 
	{  

 	 	foreach($dbh->query("select * from slo where team_id=$team_id")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
  	 			{ ?>
  	 	  			<input type="radio" name="slo_id" value="<? echo $slorow['slo_id']; ?>"  required><? echo " " . $slorow['slo_text']; ?>
  	 	  					<input type="hidden" name="slo_num" value="<? echo $slorow['slo_num']; ?>">
  	 	  					<input type="hidden" name="slo_text" value="<? echo $slorow['slo_text']; ?>"><br>
  	 			<? }
  	}
  	 else
  	  {
?>
<textarea rows="6" cols="100"  Name="expected_outcome" required></textarea></p>
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
<!-- Validation Script  -->
<script> $.validate(); </script>
<?
if($browser=="Safari") 
	{
		?>
		
<script type="text/javascript">
     	function check() 
	{
<? 
		if ($team_type==1) 
		{
?>
			
	var r = document.getElementsByName("goal")
	var c = -1
	
	for(var i=0; i < r.length; i++){
	   if(r[i].checked) {
	      c = i; 
	   }
	}
	if (c == -1) 
		{
				alert("Please select a goal.");
				return false;
		}
		 var y = document.forms["myForm"]["expected_outcome"].value;
    if (y == null || y == "") {
        alert("Expected Outcome must be filled out");
        return false;
    }	
	
<? } 
		else 
		{
			
		?>
	var r = document.getElementsByName("slo_id")
	var c = -1
	
	for(var i=0; i < r.length; i++){
	   if(r[i].checked) {
	      c = i; 
	   }
	}
	if (c == -1) 
		{
				alert("Please select a SLO.");
				return false;
		}

<?  }  ?>

    var z = document.forms["myForm"]["outcome_assessment"].value;
    if (z == null || z == "") {
        alert("Outcome Assessment Methods must be filled out");
        return false;
    }
    
    var x = document.forms["myForm"]["performance_targets"].value;
    if (x == null || x == "") {
        alert("Performance Targets must be filled out");
        return false;
    }
      
 }  
</script>
<?  }  ?>
</body>
</html>
