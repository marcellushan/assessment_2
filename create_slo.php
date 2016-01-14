<?
include "inc/init.php"; 
include 'inc/validate.php';
$team_id=$_GET['team_id'];
echo $team_name=$_GET['team_name'];

echo $sql= "SELECT * FROM slo where team_id='$team_id'";
$team_sql= "SELECT * FROM team where team_type='0' order by team_name";
$insert_sql="INSERT INTO slo (slo_text, team_id, slo_num) VALUES ('fgsdfgsd', '220', '2')";

//	$stmt = $dbh->prepare($insert_sql);
//	$stmt->execute();
	//echo $affected_rows = $stmt->rowCount();


?>
<h2>Team Membership</h2>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<option>Select Team Name</option>
<?
foreach($dbh->query($team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="create_slo.php?team_id=<? echo $row['team_id']; ?>&team_name=<? echo $row['team_name']; ?>" ><? echo $row['team_name']; ?></option>
				<?
				}
				?>
</select>

<? 
if($_GET['team_id']) 

{
		foreach($dbh->query($sql) ->fetchAll(PDO::FETCH_ASSOC) as $row2) 
				{ 	
				print_r($row2);
				}
		
	}	?>