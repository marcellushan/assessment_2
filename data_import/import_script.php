<?
session_start();
include '../inc/opendb.php';
$username = $_SESSION['username'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php");
exit(0);
}

$getuser = mysql_query("SELECT admin_users_id FROM admin_users WHERE admin_users_username='$username';", $conn3);
$adminusercheck = mysql_num_rows($getuser);

if (@$adminusercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/report.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

//Remove what's already there in the unit_team and users tables
//mysql_query("DELETE FROM unit_team;", $conn3);
//mysql_query("DELETE FROM users;", $conn3);

//use tab-delimitted file
$file = fopen("data.txt", "r") or exit("Unable to open file!");
while(!feof($file))
  {

  $aLine=explode("	",fgets($file));

  $team=$aLine[0];
  $team_goal=$aLine[1];
  $fname=$aLine[2];
  $lname=$aLine[3];
  $username=trim($aLine[4]);  //trim so me insure no spaces in the username field

//View output here:`
//echo $team . "-" . $team_goal . "-" . $fname . "-" . $lname . "-" . $username . "<br />";

//Here's where the magic happens... uncomment where necessary

//Add teams
//mysql_query("INSERT INTO unit_team (unit_team_name,unit_team_mission_statement) VALUES('$team','$team_goal');", $conn3);

//Get ID of last inserted unit_team_id
//$lastinsertid = mysql_insert_id();

//Add users to users table - with proper unit_team_id
//mysql_query("INSERT INTO users (users_fname,users_lname,users_username,unit_team_id) VALUES('$fname','$lname','$username','$lastinsertid');", $conn3);

  }
?>
