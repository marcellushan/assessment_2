<?
include "inc/init.php"; 
include 'inc/validate.php';

$slo_id=$_POST['slo_id'];
$slo_text = $_POST['slo_text'];
$team_id= $_POST['team_id'];

$update_sql="UPDATE `slo` SET `slo_text`='$slo_text ' WHERE `slo_id`='$slo_id'";
	$stmt = $dbh->prepare($update_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount(); ?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=list_slo.php?team_id=<? echo $team_id ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>