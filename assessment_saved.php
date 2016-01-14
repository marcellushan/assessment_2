<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

//Assign variables from session
//$username=$_SESSION["username"];
$team_name=$_SESSION['team_name'];
$team_type=$_SESSION['team_type'];

//Pull user data from user table
 $user_sql = "select * from users where user_username= '$username'";
 foreach($dbh->query($user_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        $user_id = $row['user_id'];
         $fname= $row['user_fname'];
        $lname= $row['user_lname'];
        $full_name = $fname . " " . $lname;
    }

//Assign POST parameters to variables
$goal = $_POST['goal'];	
@$expected_outcome = $_POST['expected_outcome'];	
$outcome_assessment = $_POST['outcome_assessment'];	
$performance_targets = $_POST['performance_targets'];	
$team_id = $_POST['team_id'];	

//Capture today's date
$my_date = date("Y-m-d");
//$my_year = date("Y");
$my_year = '2015';

//Capture the goals text from the goals table by goals_id
$goal_sql = "select goals_goal from goals where goals.goals_id='$goal'";  
 foreach($dbh->query($goal_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
       $goal_text = $row['goals_goal'];
	}

//Create new record in the assessment table, if slo_id is sent use first SQL string
if($_POST['slo_id']) 
	{
		$slo_id = $_POST['slo_id'];
		$course= $_POST['course'];
		$checksql = "select * from assessment where slo_id='$slo_id'";
		$stmt = $dbh->prepare($checksql);
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
	/*	if($affected_rows >0) 
			{?>
			<script>alert("There is an existing assessment for the SLO you selected!");</script>
			<script>window.location="assessment.php?pickteam=<? echo $team_id ?>";</script>
			
			<? }
			else
			{ */
 				$sql = "INSERT INTO assessment (team_id, user_id, create_date, assessment_period, goals_id, slo_id, course, outcome_assessment, performance_targets ) VALUES ('$team_id','$user_id', '$my_date','$my_year', '$goal','$slo_id', '$course', '$outcome_assessment', '$performance_targets')";
 			//}
	}
	else 
	{
 $sql = "INSERT INTO assessment (team_id, user_id, create_date, assessment_period, goals_id, expected_outcome, outcome_assessment,performance_targets ) VALUES ('$team_id','$user_id','$my_date','$my_year', '$goal','$expected_outcome', '$outcome_assessment', '$performance_targets')";
	}


 ?>
               <div class="well">
<h1 style="text-align:center;margin-left:auto;margin-right:auto;">
Assessment Confirmation</h1>
	<h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>


<p></p>
</div>

<?
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();
if($affected_rows < 1) 
	{
	?>
	<div class="well">
	<h2>Assessment not created!!</h2>
	</div><h2>Course Being Assessed</h2>
			<table border='1'><tr><td height="50px" width="700px" valign="top"><h3><? echo $course ?></h3></td></tr></table>
	<?
	}
else 
	{
		//grab the id of the new assessment and save it
		$last_id = $dbh->lastInsertId();
	?>
	<div class="well">
	<button type="button" onclick="final_submit(<? echo $last_id ?>);">Submit Assessment</button><p>
	<a href="Saved.php?id=<? echo $last_id ?>" >Edit Assessment</a><p>
	<?
	  if($_SESSION['list']) 
	  { ?>
	  <a href="index.php" onclick="check_submit()">Return to User Home</a><p>
	<? } ?>
	<a href="index.php?pickteam=<? echo $team_id ?>" onclick="check_submit()">Return to Team Home</a><p>
   <a href="assessment.php?pickteam=<? echo $team_id ?>" onclick="check_submit()">Create New Assessment</a><p>
	<h2>College Goal</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal_text ?></h4></td></tr></table>
	<br>
	<? if(@$_POST['slo_id']) 
		{ ?>
							<h2>Course Being Assessed</h2>
			<table border='1'><tr><td height="50px" width="700px" valign="top"><h3><? echo $course ?></h3></td></tr></table>
			<?
	 foreach($dbh->query("select * from slo where slo_id = '$slo_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
	    {
	       $slo_text=$slorow['slo_text'];
	      	    }	
		?>
			<h2>Student Learning Outcome</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4> <? echo $slo_text ?></h4></td></tr></table>
		<? }
		else
		{ ?>
	<h2>Expected Outcome</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $expected_outcome ?></h4></td></tr></table>
	 <? }  ?>
	<br>
	<br>
	<h2>Outcome Assessment Method</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $outcome_assessment ?></h4></td></tr></table>
	<br>
	<br>
	<h2>Performance Target</h2>
	<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $performance_targets ?></h4></td></tr></table>
	<br>
	<button type="button" onclick="final_submit(<? echo $last_id ?>);">Submit Assessment</button><p>
	</div>
	<?
	}
	?>
</div>  <!-- container  -->
            
            
            </body>
   </html>
