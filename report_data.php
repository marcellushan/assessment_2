<?
include "inc/init.php"; 
 include "inc/header.php";
// include 'inc/admin_validate.php';
if(@$_SESSION['access_admin']==1) 
	{
		$admin=1;
	}
	else 
	{
		$admin=@$_GET['admin'];
	}
//$admin=1;

//Capture Assessment ID from previous page
$assessment_id = $_GET["id"];


//Display record contents readonly
 $select_sql = "select team_type, team.team_id as team from assessment, team where assessment.team_id=team.team_id and assessment_id='$assessment_id'";
// $select_sql = "select * from assessment, goals where assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id";   

 foreach($dbh->query($select_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
       $team_type = $row['team_type'];
       $team_id = $row['team'];
    }
if($team_type==0) 
	{
		$sql = "SELECT * FROM assessment, goals, team, users, slo where assessment.goals_id=goals.goals_id and assessment.assessment_id='$assessment_id' and assessment.team_id=team.team_id and assessment.slo_id=slo.slo_id and assessment.user_id=users.user_id";
	}
	else 
	{
		$sql = "SELECT * FROM assessment, goals, team, users where assessment.goals_id=goals.goals_id and assessment.assessment_id='$assessment_id' and assessment.team_id=team.team_id and assessment.user_id=users.user_id";
		}
		
 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {

       $goal = $row['goals_goal'];
        $expected_outcome = $row['expected_outcome'];
        $slo_id=$row['slo_id'];
        @$course=$row['course'];
        @$slo_text=$row['slo_text'];
        $outcome_assessment= $row['outcome_assessment'];
        $performance_targets= $row['performance_targets'];
        $team_name= $row['team_name'];
        $full_name=$row['user_fname'] . " " . $row['user_lname'];
        $username= $row['user_username'];
        $create_date=$row['create_date'];
        $submit_date=$row['submit_date'];
    }

 ?>
               <div class="well">
            		            <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>
                        
                         <button type="button" onclick="location.href='print_form.php?id=<? echo $assessment_id ?>'">Print Assessment</button><p>
       			
					</div>

					<?
					if($admin==1) 
					{?>
					  <div class=".no-print">
					  <div class="well">
					  <h3>Send message to user:</h3>
					<form action="send_email.php" method="post">
					  <textarea rows="6" cols="100"  Name="email_text"></textarea>
					  <input type="hidden" name="team_name" value="<? echo $team_name; ?>">
					  <input type="hidden" name="team_type" value="<? echo $team_type; ?>">
					  <input type="hidden" name="team_id" value="<? echo $team_id; ?>">
					  <input type="hidden" name="id" value="<? echo $assessment_id; ?>">
  	 	  					<input type="hidden" name="username" value="<? echo $username; ?>"><p>
  	 	  					<input type="checkbox" name="unlock" value="1" />Unlock Assessment?<p>
					   <input type="submit" value="Send Feedback" >
					  </form>
					               </div>
					     </div>
					               
					<? } ?>
					<div class="well">
					<h2>College Goal</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal?></h4></td></tr></table>
<br>
<div class="page-break"></div>
<? 
if($team_type==0) 
{ ?>
<h2>Course Being Assessed</h2>
<table border='1'><tr><td height="50px" width="200px" valign="top"><h4><? echo $course ?></h4></td></tr></table>

<h2>Student Learning Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $slo_text ?></h4></td></tr></table>
<? }
else 

{ ?>
<h2>Expected Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $expected_outcome ?></h4></td></tr></table>
<? } ?>
<br>
<br>
<h2>Outcome Assessment</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $outcome_assessment ?></h4></td></tr></table>
<br>
<br>
<h2>Performance Target</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $performance_targets ?></h4></td></tr></table>
</div>
      </div>  <!-- container  -->
        