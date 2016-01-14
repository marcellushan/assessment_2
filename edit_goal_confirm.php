<?
include "inc/init.php"; 
include 'inc/validate.php';

$goal_id=$_POST['goal_id'];
$goal_text = $_POST['goal_text'];

$update_sql="UPDATE `goals` SET `goals_goal`='$goal_text ' WHERE `goals_id`='$goal_id'";
	$stmt = $dbh->prepare($update_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount(); ?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=goal_management.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>