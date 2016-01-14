<?
  // bootstrap header   		
 include "inc/header.php"; 
 
include "inc/init.php"; 

include 'inc/admin_validate.php';

//$team_id = $_GET['team_id'];

$sql = "select * from goals order by inactive";


 ?>
<div class="well">
<table border="1">
   <tr><th colspan='2'><h1 align='center'>Goals</h1></th></tr>
<?
     foreach($dbh->query($sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
      		{
      			
      			$goal_id=$row['goals_id'];	
      			$goal_text=$row['goals_goal'];						 		
      			$inactive=$row['inactive'];					 		
               			if($inactive==0) 
	               			{?>   
			      			<tr>
			      	
			      			<td><a href="edit_goal.php?goal_id=<? echo $goal_id ?>"><? echo $goal_text; ?></a></td><td><div align='center'><button type='button' onclick='deactivate_goal(<? echo $goal_id ?>)'>Deactivate</button></div></td>
			      			</tr>
			      			<? }
      			else 
		      			{ ?>
		      			
		      			<tr>
		      	
		      			<td><? echo $goal_text; ?></td><td><div align='center'>Inactive</div></td>
		      			</tr>
		      			<? }
      			           			
      			}     

?>
</table>
</div>
<div class="well">
<form action="new_goal.php" method="post">

<h3>Create a new Goal</h3>
<textarea rows="6" cols="100" name="goal_text"></textarea>
<p>
<p>
<input type="submit" name="goal" value="Submit" />
</form>
</div>
<div class="well">
<?
include 'link.php';
?>
</div>
</div> <!-- container -->
</body>
</html>
				