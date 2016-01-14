
<html xmlns="http://www.w3.org/1999/xhtml">

<?

include 'dbconfig.php';


//Set Username
$username='jhannah';



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

<body>
<h1 style="text-align:center;margin-left:auto;margin-right:auto;">Create
Assessment</h1>

<p></p>

<h2>Mission: <? echo $mission ?></h2>

<p></p>
<form action="confirm.php" method="post">
<h3>Related College Goal</h3>

<textarea rows="6" cols="100" Name="Related_College_Goal"></textarea></p>
<br>
<h3>Expected Outcomel</h3>

<textarea rows="6" cols="100"  Name="Expected_Outcome"></textarea></p>
<br>
<h3>Outcome Assessment Method</h3>

<textarea rows="6" cols="100"  Name="Outcome_Assessment_Method"></textarea></p>

<input type="submit" value="Save Assessment">

</form>
</body>
</html>
