<?php
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$user_id=$_GET['user_id'];
$team_sql="SELECT * FROM team";
$full_name=$_GET['full_name'];

	

 ?>
 <div class="well">  
 <h2><? echo $full_name; ?> is a member of the following teams:</h2>
             <?           

foreach($dbh->query("select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where us.user_id='$user_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $row2)														
    {

        echo "<h3>" . $team = $row2['team_name'] . "</h3>";

 // count how many teams the user is a member of, if 
       ++$i;  
    }
    
    ?>
</div>
<div class="well">
<h3>Add User <? echo $full_name; ?></h3>
<h4>Select team to add user to:</h4>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<?
foreach($dbh->query($team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="add_to_team_confirm.php?team_id=<? echo $row['team_id']; ?>&user_id=<? echo $user_id ?>&full_name=<? echo $full_name ?>&team_name=<? echo $row['team_name'] ?>"><? echo $row['team_name']; ?></option>
				<?
				}
				?>
</select>
</div>
<div class="well">
<?
include 'previous.php';
?>
</div>
<div class="well">
<?
include 'link.php';
?>
</div>
</div><!-- container -->
</body>
</html>
