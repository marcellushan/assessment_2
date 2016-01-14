<?
include "inc/init.php"; 
include 'inc/validate.php';

$slo_id = $_GET['slo'];
$team_id= $_GET['team_id'];

//Update record with Inactiveflag
$sql = "UPDATE slo SET inactive='1' WHERE slo_id = '$slo_id'";
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
