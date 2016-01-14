<?php
include "inc/init.php"; 

//$sql= "SELECT* FROM users order by user_username";
//$sql ="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where user_username='$username";
$A_sql ="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where team_type= '0' AND us.inactive='0' order by user_username";
$I_sql ="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where team_type= '1' AND us.inactive='0' order by user_username";
/*
foreach($dbh->query($sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				
				print_r($row);
				}

*/


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>

<h2>Academic</h2>
<select id="selectbox" name="" onchange="javascript:location.href = this.value;">
<?
foreach($dbh->query($A_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="index.php?username=<? echo $row['user_username']; ?>" ><? echo $row['user_username']; ?><? echo $row['team_name']; ?><? echo $row['team_id']; ?></option>
				<?
				}
				?>
</select>


<h2>Administrative</h2>
<select id="selectbox" name="" onchange="javascript:location.href = this.value;">
<?
foreach($dbh->query($I_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="index.php?username=<? echo $row['user_username']; ?>" ><? echo $row['user_username']; ?><? echo $row['team_name']; ?><? echo $row['team_id']; ?></option>
				<?
				}
				?>
</select>

</body>
</html>

