
<html xmlns="http://www.w3.org/1999/xhtml">
<?
include "inc/init.php"; 

include 'inc/validate.php';
//Set Username
$username='mhannah';

//Join the users, team and user_team tables to get the users First Name, Last name, Team and Users ID
 foreach($dbh->query("select * from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
       $mission = $row['team_mission_statement'];
        $lname= $row['users_lname'];
         $users_id = $row['users_id'];
       $team = $row['team_name'];
     
    }
?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>New Assessment</title>
  <meta name="generator" content="Bluefish 2.2.6" />
</head>

<body onload="window.print(); window.close();">
<h1 style="text-align:center;margin-left:auto;margin-right:auto;">Create
Assessment</h1>

<p></p>

<!-- Insert the team mission statement  -->
<h2>Mission: <? echo $mission ?></h2>

<p></p>
<form action="assessment_saved.php" method="post">
<?  $goals_sql = "select * from goals";
 
 // Build the goals list
 foreach($dbh->query($goals_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    { ?>
  <input type="checkbox" name="goal" value="<? echo $row['goals_id']; ?>"> <? echo $row['goals_goal']; ?><br>
<?
}
?>
</p>
<br>
<h3>Expected Outcomel</h3>

<textarea rows="6" cols="100"  Name="expected_outcome"></textarea></p>
<br>
<h3>Outcome Assessment Method</h3>

<textarea rows="6" cols="100"  Name="outcome_assessment"></textarea></p>

<input type="submit" value="Save Assessment">

</form>
</body>
</html>
