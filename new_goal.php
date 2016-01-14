<?
include "inc/init.php"; 
include 'inc/validate.php';

$goal_text= $_POST['goal_text'];

$sql = "INSERT INTO goals (goals_goal) VALUES ('$goal_text')";

$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();
?>
<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=goal_management.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>