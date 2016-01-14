<?
include "inc/init.php"; 

$assessment_id = @$_GET['id'];
//$assessment_id = 633;



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
        $slo_text=$row['slo_text'];
        $mission_statement=$row['team_mission_statement'];
        $outcome_assessment= $row['outcome_assessment'];
        $performance_targets= $row['performance_targets'];
        $team_name= $row['team_name'];
        $full_name=$row['user_fname'] . " " . $row['user_lname'];
        $username= $row['user_username'];
        $create_date=$row['create_date'];
        $submit_date=$row['submit_date'];
    }



?>
<script language="Javascript1.2">
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>


<body onload="printpage()">

<table width="1020" cellpadding="5" cellspacing="0" border="0"><td align="left" style="font-size: 20px; font-weight: bold;">Office of Strategic Planning, Assessment, &amp; Accreditation</td></tr></table>
<div style="padding: 20px; width: 990px; text-align: left;">

<table width="980" cellpadding="5" cellspacing="0" border="0">
<tr>

<!-- td valign="top" width="200" align="center"><img src="https://www.highlands.edu/images/shield_logo_ds.png" /></td -->

<td valign="top">
<table width="950" cellpadding="5" cellspacing="0" border="0">

<tr><td width="200"><b>Unit/Team</b></td><td><?  echo @$team_name; ?></td></tr>
<tr><td><b>Reported By</b></td><td><? echo @$full_name; ?></td></tr>

<tr><td><b>Assessment Period</b></td><td>2015/16
</td></tr>

<tr><td><b>Related College Goal</b></td><td><? echo @$goal; ?>
</td></tr>

<tr><td style="border-bottom: 1px #111111 solid;"><b>Unit/Team Mission Statement</b></td><td style="border-bottom: 1px #111111 solid;">
<?

echo $mission_statement;

?>


</td></tr>
<? if($team_type==1) 
	{ ?>
	<tr><td style="border-bottom: 1px #111111 solid;"><b>Expected Outcome</b></td><td style="border-bottom: 1px #111111 solid;"><?  echo $expected_outcome;  ?>&nbsp;</td></tr>
	<? } 
	 else 
	 { ?>
	  	<tr><td style="border-bottom: 1px #111111 solid;"><b>Course being assessed</b></td><td style="border-bottom: 1px #111111 solid;"><?  echo $course;  ?>&nbsp;</td></tr>
	 	<tr><td style="border-bottom: 1px #111111 solid;"><b>Student Learning Outcome</b></td><td style="border-bottom: 1px #111111 solid;"><?  echo $slo_text;  ?>&nbsp;</td></tr>
		 <?
		}
		?>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Outcome Assessment</b></td><td style="border-bottom: 1px #111111 solid;"><? echo $outcome_assessment; ?>&nbsp;</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Performance Target</b></td><td style="border-bottom: 1px #111111 solid;"><? echo $performance_targets; ?>&nbsp;</td></tr><? exit(0); ?>

</table>


</div>

</div>

</center>

<br /><br />
