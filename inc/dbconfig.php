<?php


// Set Database user name and password
$wwwuser = 'root';

$servername = $_SERVER['SERVER_NAME'];

if($servername=='webdev.highlands.edu')
	{
		//Development Server		
		 $wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh
   }
elseif($servername=='www.highlands.edu')
   {
	   	//Production Server
		 $wwwpass = 'presume-latitude-pizza-plans'; // last updated 03/26/15 mh
	}
else 
	{
		$wwwuser = 'marc';
		$wwwpass = 'F1agstaff'; // last updated 03/26/15 mh
	}

//Create Database object
$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);

/*

echo "DBgood";
$sql = "INSERT INTO goals (goals_goal) VALUES ('this crap')";
$stmt = $dbh->prepare($sql);
$stmt->execute();
echo $affected_rows = $stmt->rowCount();
echo "more";
*/
?>