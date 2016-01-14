<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

$slo_id=$_GET['slo_id'];
$team_id=$_GET['team_id'];

$sql="select * from slo where slo_id='$slo_id'";

 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
 {
 
$slo_text=$row['slo_text'];
 
 }

  // bootstrap header   		

 ?>
  <div class="well">
<h2>Edit SLO</h2>
<form action="edit_slo_confirm.php" method="post">
<textarea rows="10" cols="100" name="slo_text" required><? echo $slo_text ?></textarea> 
<input type="hidden" name="slo_id" value="<? echo $slo_id ?>">
<input type="hidden" name="team_id" value="<? echo $team_id ?>">
<input type="submit" name="Submit" value="Edit SLO" />
</form>
  </div>
  <div class="well">
<?
include 'previous.php';
?>
</div>
   </div>