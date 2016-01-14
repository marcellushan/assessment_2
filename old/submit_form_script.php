<?
session_start();
include 'inc/opendb.php';
$username = $_SESSION['username'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php");
exit(0);
}

$getuser = mysql_query("SELECT users_id FROM users WHERE users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);
$users_id = mysql_result($getuser, 0);

$getuserdetails = mysql_query("SELECT * FROM users,unit_team WHERE users.unit_team_id=unit_team.unit_team_id AND users_username='$username';", $conn3);
while($rowgetuserdetails = mysql_fetch_array($getuserdetails, MYSQL_ASSOC)) {
//$unit_team_name = $rowgetuserdetails['unit_team_name'];
//$unit_team_id = $rowgetuserdetails['unit_team_id'];
$users_fname = $rowgetuserdetails['users_fname'];
$users_lname = $rowgetuserdetails['users_lname'];
}

/*
$periodyear = date("Y");

$currentmonth = date('n');

if ($currentmonth <= "10") {
$submitmonth = "oct_submit_datetime";
}

if ($currentmonth <= "6") {
$submitmonth = "june_submit_datetime";
}
*/
if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

$unit_team_name = @$_POST['unitteam'];
$unit_team_id = @$_POST['unitteamid'];

$related_goal = mysql_real_escape_string(@$_POST['related_goal']);
$related_goal1 = $related_goal[0];
$related_goal2 = substr($related_goal, 1);
$period = @$_POST['period'];
$mission = mysql_real_escape_string(@$_POST['mission']);
$expected_outcome = mysql_real_escape_string(nl2br(@$_POST['expected_outcome']));
$outcome_assessment = mysql_real_escape_string(nl2br(@$_POST['outcome_assessment']));
$performance_targets = mysql_real_escape_string(nl2br(@$_POST['performance_targets']));
$data_summary = mysql_real_escape_string(nl2br(@$_POST['data_summary']));
$recommended_actions = mysql_real_escape_string(nl2br(@$_POST['recommended_actions']));

mysql_query("INSERT INTO assessment (users_id,users_fname,users_lname,users_username,unit_team_id,submit_datetime,assessment_period,goals_id,goals_goal,mission_statement,expected_outcome,outcome_assessment,performance_targets,data_summary,recommended_actions,unit_team_name) VALUES('$users_id','$users_fname','$users_lname','$username','$unit_team_id',NOW(),'$period','$related_goal1','$related_goal2','$mission','$expected_outcome','$outcome_assessment','$performance_targets','$data_summary','$recommended_actions','$unit_team_name');", $conn3);

//echo "Successfully Added!";

header("Location: https://www.highlands.edu/site/misc/assessment/form.php");
?>

