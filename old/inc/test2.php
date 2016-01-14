<?
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

//WebDev server hostname
$dbhost = 'localhost';
// $dbhost = 'www.highlands.edu';
$dbuser = $wwwuser;
$dbpass = $wwwpass;

$dbname3 = 'assessment';

$conn3 = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql');


$result = mysql_select_db($dbname3);
echo $result;

?>