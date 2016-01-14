<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/admin_validate.php';

$user_id=$_GET['user_id'];
$team_type=$_GET['team_type'];
	

 ?>
            <div class="well">
<h2><? echo $_GET['full_name'] ?> is a member of the following teams:</h2>
 <?           

foreach($dbh->query("select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where us.user_id='$user_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $row)														
    {

        echo "<h3>" . $team = $row['team_name'] . "</h3>";

 // count how many teams the user is a member of, if 
       @++$i;  
    }
    
    ?>
   <button type='button' onclick='deactivate_user(<? echo $user_id ?>, <? echo $team_type ?>)'>Deactivate User</button> 
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
    
