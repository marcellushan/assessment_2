<?
include "inc/init.php"; 
include 'inc/validate.php';
$goal_id = $_GET['goal_id'];


//Update record with Inactiveflag
$sql = "UPDATE goals SET inactive='1' WHERE goals_id = '$goal_id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
echo $affected_rows = $stmt->rowCount();
?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=goal_management.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
