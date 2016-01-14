<?
session_start();
include 'inc/opendb.php';
$username = $_SESSION['username'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php");
exit(0);
}

if (@$_GET['admin'] == "1") {
$getuser = mysql_query("SELECT admin_users_id FROM admin_users WHERE admin_users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);

if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/report.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

$assessment_id = @$_GET['id'];

$getassessment = mysql_query("SELECT * FROM assessment,goals WHERE goals.goals_id=assessment.goals_id AND assessment_id='$assessment_id';", $conn3);
while($rowgetassessment = mysql_fetch_array($getassessment, MYSQL_ASSOC)) {
$assessment_id = $rowgetassessment['assessment_id'];
$unit_team_a = $rowgetassessment['unit_team_name'];
$users_name_a = $rowgetassessment['users_fname'] . " " . $rowgetassessment['users_lname'];
$assessment_period = $rowgetassessment['assessment_period'];
$goal_id = $rowgetassessment['goals_id'];
$goal = $rowgetassessment['goals_goal'];
$mission_statement = $rowgetassessment['mission_statement'];
$expected_outcome = $rowgetassessment['expected_outcome'];
$outcome_assessment = $rowgetassessment['outcome_assessment'];
$performance_targets = $rowgetassessment['performance_targets'];
$data_summary = $rowgetassessment['data_summary'];
$recommended_actions = $rowgetassessment['recommended_actions'];
}
}

$getuser = mysql_query("SELECT users_id FROM users WHERE users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);

$getuserdetails = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
while($rowgetuserdetails = mysql_fetch_array($getuserdetails, MYSQL_ASSOC)) {
$unit_team = $rowgetuserdetails['unit_team_name'];
$users_name = $rowgetuserdetails['users_fname'] . " " . $rowgetuserdetails['users_lname'];
}

$periodyear = date("Y");

$currentmonth = date('n');

$octmonthset = "10";
$junemonthset = "6";

if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
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

<tr><td width="200"><b>Unit/Team</b></td><td><? if (@$_GET['admin'] == "1") { echo $unit_team_a; } else { echo @$unit_team; } ?></td></tr>
<tr><td><b>Reported By</b></td><td><? if (@$_GET['admin'] == "1") { echo $users_name_a; } else { echo @$users_name; } ?></td></tr>
<tr><td><b>Assessment Period</b></td><td><? echo $assessment_period; ?>
</td></tr>

<tr><td><b>Related College Goal</b></td><td><? echo @$goal; ?>
</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Unit/Team Mission Statement</b></td><td style="border-bottom: 1px #111111 solid;">
<?
$getunit = mysql_query("SELECT unit_team_mission_statement FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
$usermission = mysql_result($getunit,0);
if (@$_GET['admin'] == "1") { echo $mission_statement; } else {
echo $usermission;
}
?>
<input type="hidden" name="mission" value="<? echo @$usermission; ?>" />

</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Expected Outcome</b></td><td style="border-bottom: 1px #111111 solid;"><? if (@$_GET['admin'] == "1") { echo str_replace("<br />","",$expected_outcome); } ?>&nbsp;</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Outcome Assessment</b></td><td style="border-bottom: 1px #111111 solid;"><? if (@$_GET['admin'] == "1") { echo str_replace("<br />","",$outcome_assessment); } ?>&nbsp;</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Performance Targets</b></td><td style="border-bottom: 1px #111111 solid;"><? if (@$_GET['admin'] == "1") { echo str_replace("<br />","",$performance_targets); } ?>&nbsp;</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Summary of Data Collected <br />(Performance Results)</b></td><td style="border-bottom: 1px #111111 solid;"><? if (@$_GET['admin'] == "1") { echo str_replace("<br />","",$data_summary); } ?>&nbsp;</td></tr>
<tr><td style="border-bottom: 1px #111111 solid;"><b>Recommended Actions</b></td><td style="border-bottom: 1px #111111 solid;"><? if (@$_GET['admin'] == "1") { echo str_replace("<br />","",$recommended_actions); } ?>&nbsp;</td></tr>

</table>
</form>

</div>

</div>

</center>

<br /><br />
