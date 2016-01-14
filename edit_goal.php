<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

$goal_id=$_GET['goal_id'];
$sql="select * from goals where goals_id='$goal_id'";

 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
 {
 
$goal_text=$row['goals_goal'];
 
 }
 
 ?>
  <div class="well">
<h2>Edit Goal</h2>
<form action="edit_goal_confirm.php" method="post">
<textarea rows="10" cols="100" name="goal_text"><? echo $goal_text ?></textarea> 
<input type="hidden" name="goal_id" value="<? echo $goal_id ?>">
<input type="submit" name="Submit" value="Edit Goal" />
</form>
  </div>
  <div class="well">
<?
include 'previous.php';
?>
</div>
   </div>