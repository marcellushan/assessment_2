<?
session_start();
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

$slo_text= $_POST['slo_text'];
$team_id= $_POST['team_id'];

$sql = "INSERT INTO slo (slo_text, team_id) VALUES ('$slo_text','$team_id')";

$stmt = $dbh->prepare($sql);
$stmt->execute();
echo $affected_rows = $stmt->rowCount();

 ?>
  	<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=list_slo.php?team_id=<? echo $team_id ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>