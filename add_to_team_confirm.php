<?

include "inc/init.php"; 

include 'inc/admin_validate.php';

$user_id=$_GET['user_id'];
$team_sql="SELECT * FROM team";
$full_name=$_GET['full_name'];
$team_name=$_GET['team_name'];
@$team_type=$_GET['team_type'];
@$remove=$_GET['remove'];
if($remove==1) 
	{
	$team_id=$_GET['team_id'];
	$delete_sql= "DELETE FROM team_user WHERE user_id='$user_id'  AND team_id= '$team_id'";
	$stmt = $dbh->prepare($delete_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	 }
	else
{
	$team_id=$_GET['team_id'];
	$insert_sql= "INSERT INTO team_user (team_id, user_id) VALUES ('$team_id', '$user_id')";
	$stmt = $dbh->prepare($insert_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount(); 
	 }
?>

<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=team.php?team_id=<? echo $team_id ?>&team_name=<? echo $team_name ?>&team_type=<? echo $team_type ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>

</html>
