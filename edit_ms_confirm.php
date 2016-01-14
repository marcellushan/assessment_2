<?
include "inc/init.php"; 
include 'inc/validate.php';


$team_id= $_POST['team_id'];
$mission_statement=$_POST['mission_statement'];
$team_name=$_POST['team_name'];
$team_type=$_POST['team_type'];

$update_sql="UPDATE `team` SET `team_mission_statement`='$mission_statement ' WHERE `team_id`='$team_id'";
	$stmt = $dbh->prepare($update_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount(); ?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=team.php?team_id=<? echo $team_id ?>&team_name=<? echo $team_name ?>&team_type=<? echo $team_type ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
