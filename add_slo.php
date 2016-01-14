<?
include "inc/init.php"; 
include 'inc/validate.php';

echo $team= $_GET['team'];

$sql = "SELECT *  FROM slo where team_id='$team'";


 $rows = $dbh->query($sql);
 echo $count=$rows->rowCount();

?>
<form action="new_slo.php?team_id=<? echo $team ?>" method="post">
SLO #<input type="text" name="slo_num" size="5" value="" /><br>
SLO Text <input type="text" name="slo_text" size="50" value="" /><br>
<input type="submit" name="submit_slo" value="Submit" />
</form>

