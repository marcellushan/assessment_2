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
$adminusercheck = mysql_num_rows($getuser);

if (@$adminusercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/log
in.php?url=https://www.highlands.edu/site/misc/assessment/report.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

$assessment_id = @$_GET['id'];
$comments = mysql_real_escape_string($_POST['l_comments']);

if (@$assessment_id) {
$getassessment = mysql_query("SELECT * FROM assessment,goals WHERE goals.goals_id=assessment.goals_id AND assessment_id='$assessment_id';", $conn3);
while($rowgetassessment = mysql_fetch_array($getassessment, MYSQL_ASSOC)) {
$assessment_id = $rowgetassessment['assessment_id'];
$unit_team_id = $rowgetassessment['unit_team_id'];
$unit_team_a = $rowgetassessment['unit_team_name'];
$users_name_a = $rowgetassessment['users_fname'] . " " . $rowgetassessment['users_lname'];
$users_name_f = $rowgetassessment['users_fname'];
$users_username = $rowgetassessment['users_username'];
$users_email = $rowgetassessment['users_username'] . "@highlands.edu";
}
}
$getusercount = mysql_query("SELECT * FROM users WHERE users_username='$users_username';", $conn3);
$usercount = mysql_num_rows($getusercount);
if ($usercount > 1) {
$linky = "<a href=\"https://www.highlands.edu/site/misc/assessment/form.php?team=$unit_team_id\">https://www.highlands.edu/site/misc/assessment/form.php?team=$unit_team_id</a>";
$extras = " for " . $unit_team_a;
} else {
$linky = "<a href=\"https://www.highlands.edu/site/misc/assessment/form.php\">https://www.highlands.edu/site/misc/assessment/form.php</a>";
$extras = "";
}
}
mysql_query("UPDATE assessment SET assessment_lock='1',assessment_lock_datetime=NOW(),assessment_comments='$comments' WHERE assessment_id='$assessment_id';", $conn3); //allow user to update form

$message = "$users_name_f,\n\n<br /><br />Please update your Assessment Report" . $extras ." by clicking the following link:\n\n<br /><br />" . $linky . "<br /><br />Please see the following comments:<br /><br />$comments<br /><br />Thank you,<br /><br />Laura Musselwhite";

mail($users_email,"Please review and update your Assessment Report",
  $message, "From: lmusselw@highlands.edu\n" . "MIME-Version: 1.0\n" .
    "Content-type: text/html; charset=iso-8859-1" );

header("Location: https://www.highlands.edu/site/misc/assessment/form.php?admin=1&id=$assessment_id");
?>
