<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$team_id = $_GET['team_id'];

if($_GET['team_id'])

{
		$sql = "select distinct team_name, team.team_id from slo, team where slo.team_id=team.team_id AND slo.team_id= '$team_id' order by team_name";
}
else 
{
	$sql = "select distinct team_name, team.team_id from slo, team where slo.team_id=team.team_id order by team_name";
}


 ?>
<div class="well">
<table border="1">
<?

foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h1 align='center'>" . $team_name = $row['team_name']  . "</h1></th></tr>";
    	?>
    	   <tr><td width="300"><h3 align='center'>SLO Text</h3></td><td width="200"><h3 align='center'>Make Inactive</h3></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              foreach($dbh->query("select * from slo where team_id=$team_id order by inactive") ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               			
               			$slo_id=$assessrow['slo_id'];	
               			$slo_text=$assessrow['slo_text'];			
               			$inactive=$assessrow['inactive'];					 		
               			if($inactive==0) 
	               			{?>  
	               			<tr>
	               	
	               			<td><a href="edit_slo.php?slo_id=<? echo $slo_id ?>&team_id=<? echo $team_id ?>"><? echo $slo_text; ?></a></td><td><div align='center'><button type='button' onclick='deactivate_confirm(<? echo $slo_id ?>, <? echo $team_id ?>)'>Deactivate</button></div></td>
	               			</tr>
	               			<? } 
	               			else 
	               			{  ?>  
	               			<tr>
	               	
	               			<td><? echo $slo_text; ?></td><td><div align='center'>Inactive<div></td>
	               			</tr>
	               			<? }     			
               			}     
    }
?>
</table>
</div>
<div class="well">
<form action="new_slo.php" method="post">

<h3>Create a new SLO</h3>
<textarea rows="6" cols="100" name="slo_text"></textarea>
<input type="hidden" name="team_id" value="<? echo $team_id ?>">
<p>
<p>
<input type="submit" name="SLO" value="Submit" />
</form>
</div>
<div class="well">
<h3><a href="slo.php" >Return to SLO Page</a></h3>

</div>
<div class="well">
<?
include 'link.php';
?>
</div>
</div> <!-- container -->
</body>
</html>
				
