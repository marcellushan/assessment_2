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
            <h1 align="center">Team Membership</h1>
            </div>
                        <div class="well">
<?
if($team_type==1) 
	{ 
?>
<h2 align="center">Administrative</h2>
<table border="1" align="center">
                 <?
foreach($dbh->query($team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
        	 $team_id = $row['team_id'];
    	echo "<tr><th colspan='2'><a href='team.php?team_id=" . $team_id . "&team_name=" . $row['team_name'] . "&team_type=" . $team_type . "'><h3>" . $team_name = $row['team_name']  . "</h3></a></th></tr>";
    	?>

    	   <?

    	 
              foreach($dbh->query("select * from team_user join users on team_user.user_id=users.user_id where team_user.team_id='$team_id' AND inactive='0'")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               			$full_name=$assessrow['user_fname'] . " " . $assessrow['user_lname'];
               			$username=$assessrow['user_username'];
               			$user_id=$assessrow['user_id'];		
               						
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               			<td><a href="user.php?user_id=<? echo $user_id ?>&full_name=<? echo $full_name ?>&team_type=<? echo $team_type ?>"><? echo $username;?></a></td>
               			</tr>
               			<?           			
               			}    
    }
?>
</table>
<?
}
else 
{
	?>
	
<h2 align="center">Academic</h2>
<table border="1" align="center">
                 <?
foreach($dbh->query($team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	 $team_id = $row['team_id'];
    	echo "<tr><th colspan='2'><a href='team.php?team_id=" . $team_id . "&team_name=" . $row['team_name'] . "&team_type=" . $team_type . "'><h3>" . $team_name = $row['team_name']  . "</h3></a></th></tr>";
    	?>

    	   <?
    	 $team_id = $row['team_id'];
    	 
              foreach($dbh->query("select * from team_user join users on team_user.user_id=users.user_id where team_user.team_id='$team_id' AND inactive='0'")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               			$full_name=$assessrow['user_fname'] . " " . $assessrow['user_lname'];
               			$username=$assessrow['user_username'];	
               			$user_id=$assessrow['user_id'];				
               						
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               				<td><a href="user.php?user_id=<? echo $user_id ?>&full_name=<? echo $full_name ?>&team_type=<? echo $team_type ?>"><? echo $username;?></a></td>
               			</tr>
               			<?           			
               			}    
    }
?>
</table>
<?
}
?>
</div>
<div class="well">

<a href="user_management.php"><h3> Return to User Creation</h3></a> 


</div> <!-- container -->