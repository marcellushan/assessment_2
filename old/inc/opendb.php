<?php

require('/var/www/db_config.php');

$dbname3 = 'assessment';

$conn3 = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql');
//mysql_select_db($dbname3);
$result = mysql_select_db($dbname3);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
//$getassessment = mysql_query("SELECT * FROM assessment,goals WHERE goals.goals_id=assessment.goals_id AND assessment_id='$assessment_id';", $conn3);


//echo "good";
?>
