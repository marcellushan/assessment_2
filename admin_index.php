<?
include "inc/init.php"; 
include "inc/header.php"; 
include 'inc/validate.php';

//Pull the variables from the SESSION 
//$username=$_SESSION["username"];
$full_name =$_SESSION['full_name'];
$team_type =$_SESSION['team_type'] ;

//Pull the team_id from the pickteam url variable
$team_id=$_GET['pickteam'];

// Assign the team_id to the session
$_SESSION['team_id']=$team_id;

//Use the team id to get the team name from the team table, save the team name  in the session
$sql="SELECT * FROM team where team_id='$team_id'";
foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row)	
							{
							$team_name=$row['team_name'];
							}
							
// Assign the team_name to the session
$_SESSION['team_name']=$team_name;


 ?>
            <div class="well">
                        <legend>This site is used for creating, updating and submitting annual assessments.</legend>
                        <!--Background Information-->
                         <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>                         
			 		<h3 style="color: #004990;">Team : <? echo $team_name; ?> </h3>
			 		</div>
<? $re_sql="SELECT * FROM assessment where assessment_period=2014 AND team_id='$team_id' AND reassessment='0'";
$stmt=$dbh->query($re_sql);
$row_count = $stmt->rowCount();
$reassess_pending=$row_count;
if($reassess_pending > 0 ) 
		{?>

		<div class="well">
		<h3><font color="red">2014 re-assessment(s) pending for this team</font></h3>
		<? 	foreach($dbh->query($re_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row)	
							{
							$i++;
							}

			$count= $i;

// If the user is a member of an Institutional team load these functions, Located in php_functions.php
//$inst_sql="SELECT * FROM assessment where assessment_period=2014 AND assessment.team_id=$team_id";
foreach($dbh->query($re_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row)	
		{ ?>
     			<h4>Expected Outcome</h4>
				<a href="reassessment.php?id=<? echo $row['assessment_id']; ?>&expected_outcome=<? echo $row['expected_outcome']; ?>&goals_id=<? echo $row['goals_id']; ?>&pickteam=<? echo $team_id; ?>" ><? echo $row['expected_outcome']; ?></a><br>
		<? } ?>
		</div>
					<? }
		?>

<div class="well">
<?		
		institutional_completed($dbh,$team_id, 'Saved');
		//Check for submitted assessments
		institutional_completed($dbh,$team_id, 'Submitted');
//if there are pending re-assessments, hide the create button
if($reassess_pending < 1)
 {
?>
  					<br>
   					<button type="button" onclick="window.location.href='assessment.php?pickteam=<? echo $team_id; ?>'">Create New Assessment</button>     
    </div>    
    
<?
}

?>
    </div><!-- container -->
    </body>
</html>
