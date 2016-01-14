<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';
//Select all teams
$sql= "SELECT * FROM team order by team_name";

//Select all users
$users_sql= "SELECT *, concat(user_fname, ' ',user_lname) as full_name FROM users where inactive='0' order by user_lname";

//Assign variables from url parameters
$team_id=@$_GET['team_id'];
$team_name=@$_GET['team_name'];
$user_id=@$_GET['user_id'];
$full_name=@$_GET['full_name'];

//Build user list by team

$team_sql= "select *, concat(user_fname, ' ',user_lname) as full_name from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where te.team_id='$team_id'";

//Build team list by user
$user_team_sql= "select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where us.user_id='$user_id'";

 ?>
                      <div class="well">   
          <h3>Add New User</h3>
<form action="new_user.php" method="post">       
          <table>
          		<tr>
          				<td>First Name</td>
          				<td><input type="text" name="first_name" size="20" value="" required /></td>
          	  </tr>
          	  	<tr>
          				<td>Last Name</td>
          				<td><input type="text" name="last_name" size="20" value="" required /></td>
          	  </tr>
          	  	<tr>
          				<td>User Name</td>
          				<td><input type="text" name="username" size="20" value="" required maxlength="8"  /></td>
          	  </tr>
          </table>
          <input type="submit" name="user_btn" value="Add User" />
          </form>   
          </div>
            <div class="well">   
            <h3>List sysadmins</h3> 
            <?
            foreach($dbh->query("select * from users where user_admin='1' order by user_lname") ->fetchAll(PDO::FETCH_ASSOC) as $row)    
            	{
            echo $row['user_fname'] . " " . $row['user_lname'];
            echo "<br>";
            	} 
            	?>
 
          <h3>Make User sysadmin</h3>  
          <select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
            <option>Select User Name</option>
<?
foreach($dbh->query($users_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row3) 
				{ 	
				?>
				<option value="sysadmin.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
          </div>                      
<div class="well">
<h2>Manage teams and users</h2>
<a href="user_report.php?team_type=0"><h3> Academic Teams</h3></a>  
<a href="user_report.php?team_type=1"><h3> Administrative Teams</h3></a>  
</div>
<div class="well">
<?
include 'link.php';
?>
</div>
</div> <!-- container -->
<!-- Validation Script  -->
<script> $.validate(); </script>
</body>
</html>