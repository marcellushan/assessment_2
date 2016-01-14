<?

include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';


//Assign variables from post array
$user_fname= $_POST['first_name'];
$user_lname= $_POST['last_name'];
$user_username= $_POST['username'];
//$user_username= "mhannah";

$user_sql = "select * from users where user_username = '$user_username'";
$stmt = $dbh->query($user_sql);
$row_count = $stmt->rowCount();

 ?>
            <div class="well">
<?            

if($row_count < 1) 
	{
		$sql_insert = "INSERT INTO users (user_fname,user_lname, user_username, inactive) VALUES ('$user_fname','$user_lname','$user_username','0')";
		$stmt = $dbh->prepare($sql_insert);
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		if($affected_rows=='1') 
			{ ?>
			
			<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=user_management.php">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
				
			 <? }
	}
else 
	{
	?>
	<h2>Username <? echo $user_username ?> already exists!!</h2>
	 <?
	}
	?>
	
</div>
<div class="well">
<?
include 'previous.php';
?>
</div>
<div class="well">
<?
include 'link.php';
?>
</div>

