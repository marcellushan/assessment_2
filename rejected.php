<?
include "inc/init.php"; 
 //include "inc/header.php"; 
include 'inc/validate.php';

//Assign variables from session
$assessment_id = $_GET["id"];
$user_name=$_GET['username'];
$email_text = $_GET['email_text'];
$team_name=$_GET['team_name'];
$team_type=$_GET['team_type'];
$team_id=$_GET['team_id'];



//Capture Assessment ID from url variable id


//Create today's date variable
$my_date = date("Y-m-d");

//Update record with Submit_date and submitted flag
 $sql = "UPDATE assessment SET submitted='0', submit_date='$my_date' WHERE assessment_id = '$assessment_id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();


//If table is update send email to assessment admin
if($affected_rows==1) {

	 user_mail($assessment_id,$user_name, $email_text, $team_name, $team_type, $team_id, $servername) ;
}

 ?>

  <html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=sysadmin_report.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>