<?
require 'inc/dbconfig.php';
session_start();
if($_GET['admin']==1)
	{
		$admin=0;
	}
	else 
	{
		$admin=1;
	}

//Capture Assessment ID from previous page
$assessment_id = $_GET["id"];


//Display record contents readonly
 $select_sql = "select team_type, team.team_id as team from assessment, team where assessment.team_id=team.team_id and assessment_id='$assessment_id'";
// $select_sql = "select * from assessment, goals where assessment_id= '$assessment_id' AND goals.goals_id=assessment.goals_id";   

 foreach($dbh->query($select_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
       $team_type = $row['team_type'];
       $team_id = $row['team'];
    }
if($team_type==0) 
	{
		$sql = "SELECT * FROM assessment, goals, team, users, slo where assessment.goals_id=goals.goals_id and assessment.assessment_id='$assessment_id' and assessment.team_id=team.team_id and assessment.slo_id=slo.slo_id and assessment.user_id=users.user_id";
	}
	else 
	{
		$sql = "SELECT * FROM assessment, goals, team, users where assessment.goals_id=goals.goals_id and assessment.assessment_id='$assessment_id' and assessment.team_id=team.team_id and assessment.user_id=users.user_id";
		}
		
 foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {

       $goal = $row['goals_goal'];
        $expected_outcome = $row['expected_outcome'];
        $slo_id=$row['slo_id'];
        $slo_num=$row['slo_num'];
        $slo_text=$row['slo_text'];
        $outcome_assessment= $row['outcome_assessment'];
        $performance_targets= $row['performance_targets'];
        $team_name= $row['team_name'];
        $full_name=$row['user_fname'] . " " . $row['user_lname'];
        $username= $row['user_username'];
        $create_date=$row['create_date'];
        $submit_date=$row['submit_date'];
    }

?>

<!DOCTYPE html>
<html>
 <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Submitted Assessment</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/united/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <link rel="stylesheet" href="assessment.css">

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
         <script src="js_functions.js"></script>       
        
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
        
    <body style="background-color:#004990;">
    <div class="container">
      <div class="jumbotron">
                <img style="float:left; margin-right: 20px; margin-bottom: 20px;"  class="img-responsive" src="images/logo.png" />
                <h1 style="color: #004990;">Assessment Reporting</h1>
                <p style="font-weight: bold;">Detail Report</p>
            </div>
               <div class="well">
            		            <h3 style="color: #004990;"> Unit:  <? echo $team_name ?></h3>
                        <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3>
                         <h3 style="color: #004990;">Create Date : <? echo $create_date; ?> </h3>
                         <? if($submit_date) 
                         		{ ?>
                         		 <h3 style="color: #004990;">Submit Date : <? echo $submit_date; ?> </h3>
                         		 <? 
                         	}
                         	else 
                         	{ ?>
                         	 <h3 style="color: #004990;">NOT SUBMITTED </h3>
                         	 <?
                         }
                         ?>                 			
					</div>
					<?
					if($admin==1) 
					{?>
					  <div class=".no-print">
					  <div class="well">
					  <h3>Send message to user:</h3>
					<form action="send_email.php" method="post">
					  <textarea rows="6" cols="100"  Name="email_text"></textarea>
					  <input type="hidden" name="team_name" value="<? echo $team_name; ?>">
					  <input type="hidden" name="team_type" value="<? echo $team_type; ?>">
					  <input type="hidden" name="team_id" value="<? echo $team_id; ?>">
					  <input type="hidden" name="id" value="<? echo $assessment_id; ?>">
  	 	  					<input type="hidden" name="username" value="<? echo $username; ?>"><p>
					   <input type="submit" value="Send Feedback, Unlock Assessment" >
					  </form>
					  	<input type="button" onclick="window.location.href='report_data.php?id=<? echo $assessment_id ?>&admin=1'" value="Print Assessment">
					               </div>
					     </div>
					               
					<? } ?>
					<div class="well">
					<h2>College Goal</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $goal?></h4></td></tr></table>
<br>
<br>
<? 
if($team_type==0) 
{ ?>
<h2>Student Learning Objectives</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4>SLO #<? echo $slo_num ?> <? echo $slo_text ?></h4></td></tr></table>
<? }
else 

{ ?>
<h2>Expected Outcome</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $expected_outcome ?></h4></td></tr></table>

<? } ?>
<br>
<br>
<h2>Outcome Assessment</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $outcome_assessment ?></h4></td></tr></table>
<br>
<br>
<h2>Performance Target</h2>
<table border='1'><tr><td height="200px" width="700px" valign="top"><h4><? echo $performance_targets ?></h4></td></tr></table>
</div>
      </div>  <!-- container  -->
        