<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';
$user_id=$_GET['user_id'];
$full_name=$_GET['full_name'];

	

 ?>
<div class="well">
<?

	$update_sql= "UPDATE `users` SET `user_admin`='1' WHERE `user_id`='$user_id'";
	$stmt = $dbh->prepare($update_sql);
	$stmt->execute();
	$affected_rows = $stmt->rowCount(); ?>
	<h3><? echo $full_name ?> has been made a sysadmin</h3>
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
</div><!-- container -->
</body>
</html>