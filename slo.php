<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$sql_team = "SELECT team_name, team_id FROM  team where team_type=0 order by team_name";


 ?>
<div class="well">
<?
include 'link.php';
?>
</div>
     <div class="well">
   <h2>Student Learning Outcomes by Team</h2>
   <p>	
   
   <?
foreach($dbh->query($sql_team) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 
					$team_id = $row['team_id'];
					$team_name=$row['team_name'];
					 $sql = "SELECT *  FROM slo where team_id='$team_id' and inactive='0'";
 					$rows = $dbh->query($sql);
 					$count=$rows->rowCount();
 					if($count)
 						{
 							echo "<h3>" . $team_name . "      ";
 				?>
 				<a href="list_slo.php?team_id=<? echo $team_id; ?>"><? echo $count; ?></a></h3>
 					<?		
 						}
 					
				}
				?>   
   
      </div>      
    
</div><!-- container -->
</body>
</html>