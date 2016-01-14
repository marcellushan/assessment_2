<?
session_start();
//Database include - PDO object
include 'inc/dbconfig.php';

//Assign id
$reassessment=$_GET['id'];
$slo_id=$_GET['slo_id'];

//Pull Username, team_name, full_name and team_type from the SESSION
$username=$_SESSION["username"];
$team_name=$_SESSION['team_name'];
$full_name=$_SESSION['full_name'];
$team_type=$_SESSION['team_type'];
echo $goals_id=$_GET['goals_id'];

//SQL Statements

$sql="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where user_username='$username'";

//Join the users, team and user_team tables to get the users First Name, Last name, Team_name, team_id, mission_statement and Users ID
  foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
   		 {
       $mission = $row['team_mission_statement'];
       $fname= $row['user_fname'];
        $lname= $row['user_lname'];
         $user_id = $row['user_id'];
       $team_name = $row['team_name'];
       $team_type= $row['team_type'];
       $team_id = $row['team_id'];
        $full_name = $fname . " " . $lname;     
   		 }
 // Pull the user's current team from the url, if it is sent    
  if($_GET['pickteam']) 
      {
  		$team_id = $_GET['pickteam'];
  		 foreach($dbh->query("select * from team where team_id='$team_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $row2) 
  		 	{
  		 	 $team_name = $row2['team_name'];
  		 		}
  	}
  	
 
?>
<html lang="en">
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>Address Re-assessment</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/united/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootswatch.min.css">

        <!-- Datepicker -->
        <link rel="stylesheet" href="dtp/css/bootstrap-datetimepicker.min.css" />

        <!-- File Uploader -->
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="fileupload/css/jquery.fileupload.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="jquery/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.js"></script>
        <style>
            .panel a:link {
                color: #333;
                text-decoration: none;
            }
            .panel a:visited {
                color: #333;
                text-decoration: none;
            }
            .panel a:hover {
                color: #777;
                text-decoration: none;
            }
            .panel a:active {
                color: #333;
                text-decoration: none;
            }
        </style>
        
    </head>

 <body style="background-color:#004990;">
    <div class="container">
      <div class="jumbotron">
                <img style="float:left; margin-right: 20px; margin-bottom: 20px;"  class="img-responsive" src="images/logo.png" />
                <h1 style="color: #004990;">Assessment Reporting</h1>
                <p style="font-weight: bold;">Home for GHC Annual Assessment Reporting</p>
            </div>
            
     <div class="well">
<h1 style="text-align:center;margin-left:auto;margin-right:auto;">Create
Assessment</h1>

  <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>

<p></p>

<!-- Insert the team mission statement  -->
<h3>Mission: <? echo $mission ?></h3>

<p></p>
</div>
 <div class="well">
 <form action="create_reassessment.php?id=<? echo $reassessment ?>" method="post">
 <input type="submit" value="Save Assessment"><p>
 <h3>College Goal</h3>
<input type="hidden" name="team_id" value="<? echo $team_id ?>">
<input type="hidden" name="team_name" value="<? echo $team_name ?>">
 <?
 
 //If the team_type is Institutional (1) the load the goals from the database
 if($team_type==1) 
 {
 $goals_sql = "select * from goals where goals_id='$goals_id'";
 
 // Build the goals list
 foreach($dbh->query($goals_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    { ?>
  <input type="radio" name="goal" value="<? echo $row['goals_id']; ?>" required checked > <? echo $row['goals_goal']; ?><br>
	<? $label="Expected Outcome";
	}
}
else 

//If the team_type is Academic (0) then the goal is static and the SLOs are loaded from the database
{
echo $goal="<h4>Effect quality teaching and learning focused on academic achievement and personal and professional growth.</h4>";
?>
<input type="hidden" name="goal" value="1">
<?
$label="Student Learning Outcomes";
}
?>
</p>
<br>


<h3><? echo $label; ?></h3>
<? if($label=="Student Learning Outcomes") 
	{  

 	 	foreach($dbh->query("select * from slo where slo_id='$slo_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
  	 			{ ?>
  	 			<h4>SLO # <? echo $slorow['slo_num']; ?> <? echo $slorow['slo_text']; ?></h4>
  	 			<input type="hidden" name="slo_id" value="<? echo $slorow['slo_id']; ?>">
<? }
  	}
  	 else
  	  {
?>
<textarea rows="6" cols="100"  Name="expected_outcome" required><? echo $_GET['expected_outcome']; ?></textarea></p>
<? } ?>
<br>
<h3>Outcome Assessment Method</h3>

<textarea rows="6" cols="100"  Name="outcome_assessment" required></textarea></p>

<br>
<h3>Performance Targets</h3>

<textarea rows="6" cols="100"  Name="performance_targets" required></textarea></p>

<br>
<br>
 <input type="submit" value="Save Assessment"><p>
</form>
</div>
</div>
<script> $.validate(); </script>
</body>
</html>
