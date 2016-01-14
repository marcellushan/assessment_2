<?php
include "inc/init.php"; 
include 'inc/admin_validate.php';

     
$user_id=$_GET['user_id'];
$team_type=$_GET['team_type'];
$sql = "UPDATE users SET inactive='1' WHERE user_id = '$user_id'";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	if($affected_rows=='1') {
	}

?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=user_report.php?team_type=<? echo $team_type ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
