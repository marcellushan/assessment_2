<?
session_start();
//$admin=$_GET['admin'];
$admin=1;
?>

<!DOCTYPE html>
<?


include "inc/init.php"; 

include 'inc/validate.php';
$team_type= $_GET['team_type'];
$team_sql = "select team_name, team.team_id from team where team_type=$team_type order by team_name";

  // bootstrap header   		
 include "inc/header.php"; 
 ?>
<div class="well">
<?
include 'link.php';
?>
</div>
 <div class="well">
<?
if($team_type==1) 
	{ 
?>
<h1>Administrative</h1>
<div class="my-container">
                 <?
foreach($dbh->query($team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<div><div class='team-header'>" . $team_name = $row['team_name']  . "</div></div>";
    	echo "<br>";
    	?>

    	   <?
    	 $team_id = $row['team_id'];
    	 			$i = 0;
              foreach($dbh->query("select * from team_user join users on team_user.user_id=users.user_id where team_user.team_id='$team_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               			$full_name=$assessrow['user_fname'] . " " . $assessrow['user_lname'];
               			$username=$assessrow['user_username'];			
               			$i++;	
               			?>  
               			<div>
               			<div class="my-cell" ><? echo $full_name;?></div>
               			<div class="my-cell" ><? echo $username;?></div>
               			</div>
               			<?     
               			If($i > 1)
               			{
								$i=0;
               			}  
               			     	echo "<br>";   			
               			}    
    }
?>
</div>
<?
}
else 
{
	?>
	
<div class="dept-header"> Academic </div>
<div class="my-container">
                 <?
foreach($dbh->query($team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  
    echo "<br>";
    	echo "<div class='team-header'>" . $team_name = $row['team_name']  . "</div>";
    	?>

    	   <?
    	 $team_id = $row['team_id'];
    
              foreach($dbh->query("select * from team_user join users on team_user.user_id=users.user_id where team_user.team_id='$team_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               			$full_name=$assessrow['user_fname'] . " " . $assessrow['user_lname'];
               			$username=$assessrow['user_username'];			
               			$i++;	
               			?>  
               			<div>
               			<div class="my-cell"><? echo $full_name;?></div>
               			<div class="my-cell"><? echo $username;?></div>
               			</div>
               			<?     
               		
               			{
							
               			}  
               			  
  				
               			}    
    }
?>
</div>
<?
}
?>
</div>

</div> <!-- container -->