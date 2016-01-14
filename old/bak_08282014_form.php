<?
session_start();
include 'inc/opendb.php';
$username = $_SESSION['username'];

$theteam = @$_GET['team'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php");
exit(0);
}
?>
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

<?
if (@$_GET['admin'] == "1") {
$getuser = mysql_query("SELECT admin_users_id FROM admin_users WHERE admin_users_username='$username';", $conn3);
$adminusercheck = mysql_num_rows($getuser);

if (@$adminusercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/report.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

$assessment_id = @$_GET['id'];

/*
if (@$assessment_id) {

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

*/

}


$getuser = mysql_query("SELECT users_id FROM users WHERE users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);

$getusercount = mysql_query("SELECT * FROM users WHERE users_username='$username';", $conn3);
$usercount = mysql_num_rows($getusercount);
if ($usercount > 1) {
$headeradd = "";
//$unit_team_id = @$_GET['team'];
//$sqladd = "unit_team_id='$unit_team_id'";
$getunits = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
while($rowgetunits = mysql_fetch_array($getunits, MYSQL_ASSOC)) {
$unitteamid = @$rowgetunits['unit_team_id'];
$unitteamname = @$rowgetunits['unit_team_name'];
$headeradd .= "<a href=\"form.php?team=" . $unitteamid . "&year=" . @$_GET['year'] . "\">" . $unitteamname . "</a>&nbsp;&nbsp;-&nbsp;&nbsp;";
}
$sqladd = "unit_team.unit_team_id='$unitteamid'";
} else {
$sqladd = "users_username='$username'";
}

if (@$_GET['team']) {
$theteam = @$_GET['team'];
$sqladd = "unit_team.unit_team_id='$theteam'";
}

$getuserdetails = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND $sqladd;", $conn3);
while($rowgetuserdetails = mysql_fetch_array($getuserdetails, MYSQL_ASSOC)) {
$unit_team = $rowgetuserdetails['unit_team_name'];
$unit_team_id = $rowgetuserdetails['unit_team_id'];
$users_name = $rowgetuserdetails['users_fname'] . " " . $rowgetuserdetails['users_lname'];
$users_email = $rowgetuserdetails['users_username'] . "@highlands.edu";
}

if (@$_GET['year']) {
$periodyear = @$_GET['year'];
} else {
$periodyear = date("Y");
}

$currentmonth = date('n');
//$currentmonth = "4";

$octmonthset = "10";
$junemonthset = "7"; //was 6 ss 5/15/13 //was 7 ss 8/2/13

if (@$currentmonth == $octmonthset) {
$assessmentyear = $periodyear;
} elseif (@$currentmonth <= $junemonthset) {
$assessmentyear = $periodyear - 1;
} else {
$assessmentyear = $periodyear;
}

$checkassessment = mysql_query("SELECT assessment_id FROM assessment WHERE assessment_period='$assessmentyear' AND unit_team_id='$unit_team_id';", $conn3);
$assessment_check = mysql_num_rows($checkassessment);
if (@!$assessment_id) {
$assessment_id = mysql_result($checkassessment, 0); 
}

if (@$assessment_id) {
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
$assessment_lock = $rowgetassessment['assessment_lock'];
$assessment_lock_datetime = $rowgetassessment['assessment_lock_datetime'];
$users_name = $rowgetassessment['users_fname'] . " " . $rowgetassessment['users_lname'];
//$users_email = $rowgetassessment['users_username'] . "@highlands.edu";
}
}

if (@$_GET['admin'] == "1") {
} else {
if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}
}

?>
<center>
<table width="1020" cellpadding="5" cellspacing="0" border="0"><tr><td align="left" style="font-size: 28px; font-weight: bold;"></td><td align="right" style="font-size: 20px; font-weight: bold;">Office of Strategic Planning, Assessment, &amp; Accreditation</td></tr></table>
<div style="background: #cecece; padding: 20px; width: 990px; text-align: left; border-bottom: 3px #f58023 solid; border-top: 3px #f58023 solid;border-right: 1px #000000 solid;border-left: 1px #000000 solid;">

<table width="980" cellpadding="5" cellspacing="0" border="0">
<tr>

<!-- td valign="top" width="200" align="center"><img src="https://www.highlands.edu/images/shield_logo_ds.png" /></td -->

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
$getgoals = mysql_query("SELECT * FROM goals;", $conn3);
while($rowgetgoals = mysql_fetch_array($getgoals, MYSQL_ASSOC)) {
$goals_id = $rowgetgoals['goals_id'];
$goals_goal = $rowgetgoals['goals_goal'];
?>
<option value="<? echo $goals_id . $goals_goal; ?>"><? echo $goals_goal; ?></option>

<?
}
?>
</select>

</td></tr>
<tr><td><b>Unit/Team Mission Statement</b></td><td>
<?
$getunit = mysql_query("SELECT unit_team_mission_statement FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND $sqladd;", $conn3);
$usermission = mysql_result($getunit,0);
if (@$_GET['admin'] == "1") { echo $mission_statement; } else {
echo $usermission;
}
?>
<input type="hidden" name="mission" value="<? echo @$usermission; ?>" />


</td></tr>
<tr><td><b>Expected Outcome</b></td><td><textarea name="expected_outcome" rows="10" cols="75" <? if (($assessment_check >= "1") && (@$_GET['admin'] != "1") && (@$assessment_lock != "1")) { echo "READONLY"; } ?>><? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo str_replace("<br />","",$expected_outcome); } ?></textarea></td></tr>
<tr><td><b>Outcome Assessment Method</b></td><td><textarea name="outcome_assessment" rows="10" cols="75" <? if (($assessment_check >= "1") && (@$_GET['admin'] != "1") && (@$assessment_lock != "1")) { echo "READONLY"; } ?>><? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo str_replace("<br />","",$outcome_assessment); } ?></textarea></td></tr>
<tr><td><b>Performance Targets</b></td><td><textarea name="performance_targets" rows="10" cols="75" <? if (($assessment_check >= "1") && (@$_GET['admin'] != "1") && (@$assessment_lock != "1")) { echo "READONLY"; } ?>><? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo str_replace("<br />","",$performance_targets); } ?></textarea></td></tr>
<tr><td><b>Summary of Data Collected <br />(Performance Results)</b></td><td><textarea name="data_summary" rows="10" cols="75" <? if (($currentmonth != $junemonthset) && (@$_GET['admin'] != "1") && (@$assessment_lock != "1")) { echo "READONLY"; } ?> <? if (($assessment_check < 1) && (@$_GET['admin'] != "1")) { echo "READONLY"; } ?>><? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo str_replace("<br />","",$data_summary); } ?></textarea></td></tr>
<tr><td><b>Recommended Actions</b></td><td><textarea name="recommended_actions" rows="10" cols="75" <? if (($currentmonth != $junemonthset) && (@$_GET['admin'] != "1") && (@$assessment_lock != "1") && (@$assessment_lock != "1")) { echo "READONLY"; } ?> <? if (($assessment_check < 1) && (@$_GET['admin'] != "1")) { echo "READONLY"; } ?>><? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo str_replace("<br />","",$recommended_actions); } else { ?>1) Change(s) that will be made to teaching or assessment to improve results and close the loop on this outcome


2) Rationale for the change(s)


3) Anticipated time-frame for the change(s) to show results

<? } ?>
</textarea></td></tr>


<tr><td><input type="submit" value="<? if ((@$_GET['admin'] == "1") || ($assessment_check >= "1")) { echo "Update Form"; } else { echo "Submit Form"; } ?>" <? //if ((@$_GET['admin'] != "1") && (@$assessment_lock != "1")) { echo "DISABLED1"; } ?> <? if (@$_GET['year']) { echo "DISABLED"; } ?> /></td><td></td></tr>

</table>
</form>

</div>

</div>

</center>

<br /><br />
