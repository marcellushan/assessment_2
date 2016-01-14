<?
session_start();

include "inc/init.php"; 

include 'inc/validate.php';

$team_id=$_GET['team_id'];
$users_sql= "SELECT *, concat(user_fname, ' ',user_lname) as full_name FROM users where inactive='0' order by user_lname";
$team_name= $_GET['team_name'];

if($_GET['team_type']=='0' || $_GET['team_type']=='1') 
	{
		$team_type=$_GET['team_type'];
		$_SESSION['team_type'] = $team_type;
	}
	else 
	{
			$team_type=$_SESSION['team_type'];
	}


  // bootstrap header   		
 include "inc/header.php"; 
 ?>
       <div class="well">   
          <h3>Add User to the Sysadmin team</h3>  
          <select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
            <option>Select User Name</option>
<?
foreach($dbh->query($users_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row3) 
				{ 	
				?>
				<option value="add_to_team_confirm.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>&team_id=<? echo $team_id; ?>&team_name=<? echo $team_name; ?>" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
          </div>
      <div class="well">   
          <h3>Remove User from the Sysadmin team</h3>  
          <select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
            <option>Select User Name</option>
<?
foreach($dbh->query("select *, concat(user_fname, ' ',user_lname) as full_name from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where te.team_id='$team_id' AND us.inactive='0'")  ->fetchAll(PDO::FETCH_ASSOC) as $row3)														
				{ 	
				?>
				<option value="add_to_team_confirm.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>&team_id=<? echo $team_id; ?>&team_name=<? echo $team_name; ?>&remove=1" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
          </div>
<div class="well">
<a href="user_report.php?team_type=<? echo $team_type ?>"><h3> Return to Team List</h3></a> 
</div>
          <div class="well">
<?
include 'link.php';
?>
</div>
    </div><!-- containter -->
    </body>
    </html>
      