<?
session_start();
include 'inc/opendb.php';
$username = $_SESSION['username'];

$theteam = @$_GET['team'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php");
exit(0);
}

$getuser = mysql_query("SELECT admin_users_id FROM admin_users WHERE admin_users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);

if (@$_GET['admin'] == "1") {
if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/report.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}
}

$users_id = mysql_result($getuser, 0);

$getuserdetails = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
while($rowgetuserdetails = mysql_fetch_array($getuserdetails, MYSQL_ASSOC)) {
$unit_team_name = $rowgetuserdetails['unit_team_name'];
$unit_team_id = $rowgetuserdetails['unit_team_id'];
$users_fname = $rowgetuserdetails['users_fname'];
$users_lname = $rowgetuserdetails['users_lname'];
}

//$periodyear = date("Y");

/*
if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}
*/

$assessment_id = @$_GET['id'];

if (@$assessment_id) {
$getassessment = mysql_query("SELECT * FROM assessment,goals WHERE goals.goals_id=assessment.goals_id AND assessment_id='$assessment_id';", $conn3);
while($rowgetassessment = mysql_fetch_array($getassessment, MYSQL_ASSOC)) {$assessment_id = $rowgetassessment['assessment_id'];
$unit_team_a = $rowgetassessment['unit_team_name'];
$users_name_a = $rowgetassessment['users_fname'] . " " . $rowgetassessment['users_lname'];
$users_name_f = $rowgetassessment['users_fname'];
$users_email = $rowgetassessment['users_username'] . "@highlands.edu";
$assessment_lock = $rowgetassessment['assessment_lock'];
}
}

$related_goal = @$_POST['related_goal'];
$related_goal1 = $related_goal[0];
$related_goal2 = substr($related_goal, 1);
$period = @$_POST['period'];
$mission = mysql_real_escape_string(@$_POST['mission']);
$expected_outcome = mysql_real_escape_string(nl2br(@$_POST['expected_outcome']));
$outcome_assessment = mysql_real_escape_string(nl2br(@$_POST['outcome_assessment']));
$performance_targets = mysql_real_escape_string(nl2br(@$_POST['performance_targets']));
$data_summary = mysql_real_escape_string(nl2br(@$_POST['data_summary']));
$recommended_actions = mysql_real_escape_string(nl2br(@$_POST['recommended_actions']));

if (@$_GET['admin'] == "1") {
mysql_query("UPDATE assessment SET assessment_period='$period',goals_id='$related_goal1',goals_goal='$related_goal2',expected_outcome='$expected_outcome',outcome_assessment='$outcome_assessment',performance_targets='$performance_targets',data_summary='$data_summary',recommended_actions='$recommended_actions',assessment_lock='0' WHERE assessment_id='$assessment_id';", $conn3);
} else {
mysql_query("UPDATE assessment SET goals_id='$related_goal',goals_goal='$related_goal2',expected_outcome='$expected_outcome',outcome_assessment='$outcome_assessment',performance_targets='$performance_targets',data_summary='$data_summary',recommended_actions='$recommended_actions',assessment_lock='0' WHERE assessment_id='$assessment_id';", $conn3);
}

if (@$assessment_lock == "1") {

$message = "$users_name_a has updated his/her Assessment Report.  Please click this link:\n\n<br /><br /><a href=\"https://www.highlands.edu/site/misc/assessment/form.php?admin=1&id=$assessment_id\">https://www.highlands.edu/site/misc/assessment/form.php?admin=1&id=$assessment_id</a>";

mail("lmusselw@highlands.edu","Assessment Report has been updated",
  $message, "From: web@highlands.edu\n" . "MIME-Version: 1.0\n" .
    "Content-type: text/html; charset=iso-8859-1" );

}

//echo "Successfully Updated!";
if (@$_GET['admin'] == "1") {
header("Location: https://www.highlands.edu/site/misc/assessment/form.php?id=$assessment_id&admin=1");
} else if ($theteam) {
header("Location: https://www.highlands.edu/site/misc/assessment/form.php?team=$theteam");
} else {
header("Location: https://www.highlands.edu/site/misc/assessment/form.php");
}
?>

