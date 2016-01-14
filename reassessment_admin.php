<?
//Database include - PDO object
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$I_rea_sql="SELECT * FROM assessment, team where assessment_period='2014' AND assessment.team_id=team.team_id AND team_type='1'";
$A_rea_sql="SELECT * FROM assessment, team where assessment_period='2014' AND assessment.team_id=team.team_id AND team_type='0'";
$I_team_sql= "SELECT * FROM team where team_type='1' order by team_name";
$A_team_sql= "SELECT * FROM team where team_type='0' order by team_name";

$stmt = $dbh->prepare($A_rea_sql);
$stmt->execute();
echo $A_affected_rows = $stmt->rowCount();

$stmt = $dbh->prepare($I_rea_sql);
$stmt->execute();
echo $I_affected_rows = $stmt->rowCount();

 ?>
<div class="well">
<h1 align="center">Current Re-assessments</h1>
<?
if($I_affected_rows > 0) 
	{ ?>
	<h2>Administrative</h2>
	<table>
		<tr>
			<td width="150"><h3>Team</h3></td><td width="350"><h3>Goal</h3></td><td width="350"><h3>Expected Outcome</h3></td><td><h3>Resolved?</h3></td>
		</tr>
		<?
foreach($dbh->query("SELECT * FROM assessment, team, goals  where assessment_period='2014' AND assessment.team_id=team.team_id AND team_type='1' AND assessment.goals_id=goals.goals_id order by team_name") ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{  ?> 	
				<tr>
					<td><? echo $row['team_name']; ?></td>
					<td><? echo $row['goals_goal']; ?></td>
					<td><? echo htmlentities($row['expected_outcome']); ?></td>
					<td>
					<? if($row['reassessment'] > 0) 
						{ ?>
						<a href="report_data.php?id=<? echo $row['reassessment']; ?>" >Yes</a>
						<?
						} 
						else 
						{echo "No";} ?>
						</td>				
				</tr>
						<?
			}
		?>
		</table>
		<?	
	}

if($A_affected_rows > 0) 
	{ ?>
	<h2>Academic</h2>
	<table>
		<tr>
			<td width="350"><h3>Team</h3></td><td width="600"><h3>Student Learning Outcome</h3></td><td><h3>Resolved?</h3></td>
		</tr>
		<?
foreach($dbh->query("SELECT * FROM assessment, team, slo  where assessment_period='2014' AND assessment.team_id=team.team_id AND slo.slo_id=assessment.slo_id order by team_name") ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ $id=$row['reassessment'];
				 ?> 	
				<tr>
					<td><? echo $row['team_name']; ?></td>
					<td><? echo htmlentities($row['slo_text']);  ?></td>
					<!--<td><? if($row['reassessment'] > 0) { echo "Yes"; } else {echo "No";} ?></td>	 -->
					<td><? 
					
					if($id> 0) 
						{
						?> <a href="report_data.php?id=<? echo $id ?>" >Yes</a>
						<?
							}	
						 else {echo "No";} ?></td>	
				</tr>
						<?
			}
		?>
		</table>
		<?	
	}


	?>
</div>
<div class="well">
<?
include 'link.php';
?>
</div>


<div class="well">
<h1 align="center" >2014 Re-Assessments</h1>
		 <h2>Administrative Teams</h2>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<option>Select Team Name</option>
<?
foreach($dbh->query($I_team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="reassessment_admin.php?I_team_id=<? echo $row['team_id']; ?>&team_name=<? echo $row['team_name']; ?>" ><? echo $row['team_name']; ?></option>
				<?
				}
				?>
</select>
<br>
<br>
 <h2>Academic Teams</h2>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<option>Select Team Name</option>
<?
foreach($dbh->query($A_team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="reassessment_admin.php?A_team_id=<? echo $row['team_id']; ?>&team_name=<? echo $row['team_name']; ?>" ><? echo $row['team_name']; ?></option>
				<?
				}
				?>
</select>
</div>

<?

if($_GET['I_team_id']) 
	{ ?>
	<div class="well">
	<h2><? echo $_GET['team_name'] ?></h2>
<form action="add_reassessment.php" method="post">
<input type="hidden" name="team_id" value="<? echo $_GET['I_team_id'] ?>" />
<input type="hidden" name="assessment_period" value="2014" />
		<br>
	<?
	  $goals_sql = "select * from goals where inactive='0'";
 
 // Build the goals list
 foreach($dbh->query($goals_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    { ?>
  <input type="radio" name="goal" value="<? echo $row['goals_id']; ?>" required> <? echo $row['goals_goal']; ?><br>
	<? //$label="Expected Outcome";
	}
	
	?>
<h3>Expected Outcome</h3>

<textarea rows="6" cols="100"  Name="expected_outcome"></textarea></p>

<br>
<br>
 <input type="submit" value="Submit 2014 Re-assessment"><p>
</form>
	<? } ?>
	
	<?

if($_GET['A_team_id']) 
	{ 
	$team_id= $_GET['A_team_id'];?>
	<div class="well">
	<h2><? echo $_GET['team_name'] ?></h2>
<form action="add_reassessment.php" method="post">
<input type="hidden" name="team_id" value="<? echo $team_id ?>" />
<input type="hidden" name="assessment_period" value="2014" />
		<br>
<?

 	 	//foreach($dbh->query("select * from slo where team_id=$_GET['A_team_id']")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
 	 	foreach($dbh->query("select * from slo where team_id=$team_id")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
  	 			{ ?>
  	 	  			<input type="radio" name="slo_id" value="<? echo $slorow['slo_id']; ?>"><? echo " " . $slorow['slo_text']; ?>
  	 	  					<input type="hidden" name="slo_num" value="<? echo $slorow['slo_num']; ?>">
  	 	  					<input type="hidden" name="slo_text" value="<? echo $slorow['slo_text']; ?>">
  	 	  					 <input type="hidden" name="expected_outcome" value="1"<br><br>
  	 			<? } ?>

<br>
 <input type="submit" value="Submit 2014 Re-assessment"><p>
</form>
	<? } ?>
	</div>
	</div><!-- container -->
	</body>
	</html>