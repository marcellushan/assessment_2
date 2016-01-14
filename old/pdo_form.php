<?
// Set username
$username = "amaddox";

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

//WebDev server hostname
$dbhost = 'localhost';
$dbuser = $wwwuser;
$dbpass = $wwwpass;

//Set DB name
$dbname3 = 'assessment';

// Create PDO Connection object
    $dbh = new PDO('mysql:host=localhost;dbname=assessment', $wwwuser, $wwwpass);

//Set $assessment for the id URL parameter if it's there  
  $assessment_id = @$_GET['id'];
  
  //Check to see if user is in the users table
  $getuser = $dbh->query("SELECT users_id FROM users WHERE users_username='$username'");
  $usercheck = $getuser->rowCount();

//Check to see if user is a member of more than one team
$getusercount =$dbh->query("SELECT users_id FROM users WHERE users_username='$username'");
$usercount =$getusercount->rowCount();	
//If user is a member of more than one team, then build a header with links to assessments
if ($usercount > 1) 
	{
		$headeradd = "";
 		foreach($dbh->query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username'") ->fetchAll(PDO::FETCH_ASSOC) as $row)
  				{
  					$unitteamid =$row ['unit_team_id'];
  					$unitteamname = $row['unit_team_name'];
  					$headeradd .= "<a href=\"form.php?team=" . $unitteamid . "&year=" . @$_GET['year'] . "\">" . $unitteamname . "</a>&nbsp;&nbsp;-&nbsp;&nbsp;";
				}

//Set the team id to the last team in the list
	$sqladd = "unit_team.unit_team_id='$unitteamid'";
	}
else

//If not in more than one team search by username
	{
		$sqladd = "users_username='$username'";
	}

//If there is a team parameter assign it to the $theteam variable and use it to build the SQL string
if (@$_GET['team'])
	 {	
		$theteam = @$_GET['team'];
		$sqladd = "unit_team.unit_team_id='$theteam'";
	}

//Use the appropriate SQL string to query the database and populate the variable
foreach($dbh->query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND $sqladd") ->fetchAll(PDO::FETCH_ASSOC) as $row)
	{
		$unit_team = $row['unit_team_name'];
		$unit_team_id = $row['unit_team_id'];
		$unit_name = $row['users_fname']." ".$row['users_lname'];
		$unit_email = $row['users_username']."highlands.edu";
	}

//If there is a year parameter on the URL assign it to the $periodyear variable
if (@$_GET['year']) 
	{
		$periodyear = @$_GET['year'];
	}	
 else 
 //Else set $periodyear to the current year
 	{
		$periodyear = date("Y");
	}
// Set $currentmonth to the current month
$currentmonth = date('n');
//$currentmonth = "8";

$octmonthset = "10";
$junemonthset = "7"; //was 6 ss 5/15/13 //was 7 ss 8/2/13


//If current month is before July, then subtract 1 from the current year, otherwise use the current year
if (@$currentmonth == $octmonthset) {
$assessmentyear = $periodyear;
} elseif (@$currentmonth <= $junemonthset) {
$assessmentyear = $periodyear - 1;
} else {
$assessmentyear = $periodyear;
}
//Check to see if there is an assessment for the designated period
$checkassessment =$dbh->query("SELECT assessment_id FROM assessment WHERE assessment_period='$assessmentyear' AND unit_team_id='$unit_team_id';");
$assessment_check =$checkassessment->rowCount();	
//If assessment_id is not set, set if from the SQL statement
if(@!$assessment_id) 
	{
		$row = $checkassessment->fetch();
		$assessment_id = $row['assessment_id'];
		}
//echo $assessment_id;
//Query the database for the data for the selected assessment
if (@$assessment_id) 
	{
		foreach($dbh->query("SELECT * FROM assessment,goals WHERE goals.goals_id=assessment.goals_id AND assessment_id='$assessment_id';") ->fetchAll(PDO::FETCH_ASSOC) as $row);	
		
 $assessment_id = $row['assessment_id'];
 $unit_team_a = $row['unit_team_name'];
 $users_name_a = $row['users_fname'] . " " . $row['users_lname'];
 $assessment_period = $row['assessment_period'];
 $goal_id = $row['goals_id'];
 $goal = $row['goals_goal'];
 $mission_statement = $row['mission_statement'];
 $expected_outcome = $row['expected_outcome'];
 $outcome_assessment = $row['outcome_assessment'];
 $performance_targets = $row['performance_targets'];
 $data_summary = $row['data_summary'];
 $recommended_actions = $row['recommended_actions'];
 $assessment_lock = $row['assessment_lock'];
 $assessment_lock_datetime = $row['assessment_lock_datetime'];
 $users_name = $row['users_fname'] . " " . $row['users_lname'];
//$users_email = $rowgetassessment['users_username'] . "@highlands.edu";

}

echo $goal;
//  CODE ABOVE EDITTED


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />

<style>
a {
        color: #000000;
        font-size: 14px;
        text-decoration: underline;
        font-weight: bold;
}

a:hover {
        color: #E87511;
        font-weight: bold;
        text-decoration: none
}


</style>
<title>Assessment with PDO</title>
</head>
<body>
<center>
<table width="1020" cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="left" style="font-size: 28px; font-weight: bold;"></td>
		<td align="right" style="font-size: 20px; font-weight: bold;">Office of Strategic Planning, Assessment, &amp; Accreditation</td>
	</tr>
</table>

<div style="background: #cecece; padding: 20px; width: 990px; text-align: left; border-bottom: 3px #f58023 solid; border-top: 3px #f58023 solid;border-right: 1px #000000 solid;border-left: 1px #000000 solid;">

<table width="980" cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td valign="top">
			<b style="font-size: 20px;">Assessment Report Form</b>&nbsp;&nbsp;<? if (!@$_GET['admin']) { echo "<a href=\"print.php?id=$unit_team_id&year=$periodyear\" target=\"_new\"><img src=\"printer.png\" border=\"0\"></a>"; } ?><? if (@$_GET['admin'] == "1") { ?>&nbsp;&nbsp;<a href="report.php">Back to Report</a>&nbsp;&nbsp;<a href="print_form.php?admin=1&id=<? echo @$assessment_id; ?>" target="_new"><img src="printer.png" border="0"></a><? } ?>
<div style="width: 950px; background: #f1f1f1; padding: 10px; border: 1px #000000 solid;">


<table width="950" cellpadding="5" cellspacing="0" border="0">
<? if ((@$_GET['admin'] == "1") && (@$assessment_lock != "1")) { ?>

<tr><td><b>Return Assessment Form</b></td><td>
<form action="return_script.php?id=<? echo @$assessment_id; ?>&admin=1" method="POST">
Return to <? echo $users_name; ?> for editing - add comments below and press submit:<br /><br />
<textarea name="l_comments" rows="5" cols="55"></textarea><br /><br />
<input type="submit" value="Submit" />

</form>
<tr><td colspan="2"><hr />&nbsp;</td></tr>
<!-- a href="return_script.php?id=<? //echo @$assessment_id; ?>&admin=1">Return to <? //echo $users_name; ?> for editing</a></td></tr --> <? } else if (@$_GET['admin'] == "1") { ?>

<tr><td colspan="2">You returned this form to <? echo $users_name; ?> for editing on <? echo $assessment_lock_datetime; ?> - you'll be notified by email when it's resubmitted.</td></tr>
<tr><td colspan="2"><hr />&nbsp;</td></tr>

<? } ?>
<form action="<? if (@$_GET['admin'] == "1") { echo "update_form_script.php?id=$assessment_id&admin=1"; } elseif ($assessment_check >= "1") { echo "update_form_script.php?id=$assessment_id&team=$theteam"; } else { echo "submit_form_script.php"; } ?>" method="post">

<?
if ($usercount > 1) {
?>
<tr><td colspan="2"><? if (@$_GET['admin'] == "1") { } else { echo substr($headeradd, 0, -13); } ?></td></tr>
<? } ?>

<? if ((@$_GET['admin'] != "1") && (!@$_GET['year'])) {
?>
<tr><td width="150"><b>Past Reports by Year:</b></td><td>
<? 
$getyears = mysql_query("SELECT assessment_period FROM assessment WHERE unit_team_id='$unit_team_id' AND assessment_period<>'$periodyear';", $conn3);
while($rowgetyears = mysql_fetch_array($getyears, MYSQL_ASSOC)) {
echo "<a href=\"form.php?year=" . $rowgetyears['assessment_period'] . "\">" . $rowgetyears['assessment_period'] . "</a>&nbsp;&nbsp;";
}

?>

</td></tr>
<?
}
?>


<? 
if (@$_GET['year']) {
echo "<tr><td colspan=\"2\"><a href=\"form.php\">Back to current year</a></td></tr>";
}
?>

<tr><td width="100"><b>Unit/Team</b></td><td><? if (@$_GET['admin'] == "1") { echo $unit_team_a; } else { echo @$unit_team; } ?></td></tr>
<input type="hidden" name="unitteam" value="<? if (@$_GET['admin'] == "1") { echo $unit_team_a; } else { echo @$unit_team; } ?>">
<input type="hidden" name="unitteamid" value="<? if (@$_GET['admin'] == "1") { echo $unit_team_id; } else { echo @$unit_team_id; } ?>">
<tr><td><b>Reported By</b></td><td><? if (@$_GET['admin'] == "1") { echo $users_name_a; } else { echo @$users_name; } ?></td></tr>
<tr><td><b>Assessment Period</b></td><td><select name="period">
<? if (@$_GET['admin'] == "1") { ?><option value="<? echo $assessment_period - 1; ?>"><? echo ($assessment_period -1) . "-" . ($assessment_period); ?></option><? } ?>
<option SELECTED value="<? if (@$_GET['admin'] == "1") { echo $assessment_period; } else { echo $assessmentyear; } ?>"><? if (@$_GET['admin'] == "1") { echo $assessment_period . "-" . ($assessment_period + 1); } else { echo $assessmentyear . "-" . ($assessmentyear + 1); } ?></option>


<? if (@$_GET['admin'] == "1") { ?>
<? while ($x <= 4) {
$theyear = $periodyear + $x;
?>
<option value="<? echo $theyear; ?>"><? echo $theyear . "-" . ($theyear +1); ?></option>

<? $x++;
}
}
?>

</select>

</td></tr>

<tr><td><b>Related College Goal</b></td><td><select name="related_goal" style="width:500px;overflow:hidden;">
<? /*if (@$_GET['admin'] == "1") { */ if (@$goal) { ?><option value="<? echo @$goal_id . $goal; ?>"><? echo @$goal; ?></option><? } else {  } ?>
<?

foreach($dbh->query("SELECT * FROM goals") ->fetchAll(PDO::FETCH_ASSOC) as $row)
//$getgoals = mysql_query("SELECT * FROM goals;", $conn3);

// $assessment_id = $row['assessment_id'];
 //$unit_team_a = $row['unit_team_name'];
while($rowgetgoals = mysql_fetch_array($getgoals, MYSQL_ASSOC)) {
$goals_id = $row['goals_id'];
$goals_goal = $row['goals_goal'];
?>
<option value="<? echo $goals_id . $goals_goal; ?>"><? echo $goals_goal; ?></option>

<?
}
?>
</select>
</body>
</html>


