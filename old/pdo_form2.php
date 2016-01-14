<?
// Set username
$username = "mhannah";

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
    $dbh = new PDO('mysql:host=localhost;dbname=assessment_2', $wwwuser, $wwwpass);

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

foreach($dbh->query("SELECT * FROM goals;") ->fetchAll(PDO::FETCH_ASSOC) as $row)
	{
		echo $goals = $row['goals_goal'];
}
echo "test";
echo $unit_team_a;
?>

<html><head><meta content="text/html; charset=ISO-8859-1"http-equiv="content-type"><title>Assessment Home</title></head><body><h1 style="text-align: right;">Office of Strategic Planning,Assessment, &amp;Accreditation</h1><br><table style="text-align: left; width: 100%;" border="1" cellpadding="2"cellspacing="2"><tbody><tr><td>Assessment Report </td></tr><tr><td style="vertical-align: top;"><table style="text-align: left; width: 100%;" border="0"cellpadding="2" cellspacing="2"><tbody><tr><td style="vertical-align: top;">Past Report by Year<br></td><td style="vertical-align: top;">2014<br></td></tr><tr><td style="vertical-align: top;">Unit/Team<br></td><td style="vertical-align: top;"><? echo $unit_team_a;?><br></td></tr><tr><td style="vertical-align: top;">Reported by<br></td><td style="vertical-align: top;"><? echo $users_name;?><br></td></tr><tr><td style="vertical-align: top;">Assessment Period<br></td><td style="vertical-align: top;"><br></td></tr><tr><td style="vertical-align: top;">Related College Goal<br></td><td style="vertical-align: top;"><select name="Goals">

<? foreach($dbh->query("SELECT * FROM goals;") ->fetchAll(PDO::FETCH_ASSOC) as $row)
	{
?>

		<option>	<?	echo $goals = $row['goals_goal'];?></option>
<?
}?><option>Four</option></select><br></td></tr><tr><td style="vertical-align: top;">Expected Outcome<br></td><td style="vertical-align: top;"><select name="Expected Outcome"><option value="1">Information Security & Network Services (ISNS) will provide security-awareness training to faculty and staff via development of an in-house training portal or purchase of SANS: Securing The Human training.</option><option value="2">Information Security & Network Services (ISNS) will log critical data from any applicable Windows servers, as has already been done with Linux servers.</option><option value="3">Information Technology Services will provide a reliable level of service and support to the user community.</option>
<option value="4">Information Technology Services will provide a reliable level of service and support to the user community.</option>
</select></td></tr><tr><td style="vertical-align: top;">Outcome Assessment Method<br></td><td style="vertical-align: top;"><textarea cols="90"rows="10" name="Outcome_Assessment"><? echo  $outcome_assessment; ?></textarea><br></td></tr><tr><td style="vertical-align: top;">Performance Targets<br></td><td style="vertical-align: top;"><textarea cols="90"rows="10" name="Outcome_Assessment"></textarea> </td></tr><tr><td style="vertical-align: top;">Summary of Data CollectedPerformance Results<br></td><td style="vertical-align: top;"><textarea cols="90"rows="10" name="Outcome_Assessment"></textarea> </td></tr></tbody></table></td></tr></tbody></table><br><br></body></html>
