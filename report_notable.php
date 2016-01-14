<?
include "inc/init.php"; 
 include "inc/header.php"
include 'inc/admin_validate.php';
$admin=$_GET['admin'];
?>

<!DOCTYPE html>
<?


require 'inc/dbconfig.php';
include 'inc/php_functions.php';
$acad_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='0' AND assessment_period='2015' AND submitted='1' order by team_name";
$inst_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='1' AND assessment_period='2015' AND submitted='1' order by team_name";

$saved_acad_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='0' AND assessment_period='2015' AND submitted='0' order by team_name";
$saved_inst_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='1' AND assessment_period='2015' AND submitted='0' order by team_name";

  // bootstrap header   		
 include "inc/header.php"; 
 ?>
            <div class="well">
            <h1 align="center">Assessment Reporting</h1>
            </div>
 <? 
 if($admin==1) 
 	{
 		?>
            <div class="well">
<?
include 'link.php';
?>
</div>
<?
}
?>
              <div class="well">
            <h2 align="center">Submitted</h2>
            </div>
                        <div class="well">
<h2>Academic</h2>
<div style="width: 600px;">
                 <?
foreach($dbh->query($acad_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<div><div style="float: left; width: 50%;"><h3>" . $team_name = $row['team_name']  . "</h3><div style="float: left; width: 50%;"></div>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="100"><h4>Create Date</h4></td><td width="130"><h4>Submit Date</h4></td><td width="700"><h4>Student Learning Objectives</h4></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              foreach($dbh->query("select * from assessment,slo, team_user join users on team_user.user_id=users.user_id where assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id AND assessment_period='2015' AND  submitted='1' AND team_user.team_id='$team_id' order by slo_num")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               						
									   $expected_outcome=$assessrow['expected_outcome'];               			
               						 $assessment_id=$assessrow['assessment_id'];    
               						 $username=$assessrow['user_username']; 
               						$fname = $assessrow['user_fname'];
       								$lname= $assessrow['user_lname'];
       								$submitted=$assessrow['submitted'];
       								$create_date= $assessrow['create_date'];
       								$submit_date= $assessrow['submit_date'];
       								$slo_id=$assessrow['slo_id'];
       								$slo_num=$assessrow['slo_num'];
       								$full_name = $fname . " " . $lname;
               					foreach($dbh->query("select slo_text from slo where slo_id='$slo_id'")	 ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
               						{
											$slo_text= $slorow['slo_text'];     						
               						}	
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               			<td><? echo $create_date;?></td>
               			<td><? echo $submit_date;?></td>
               			<td><a href="report_data.php?id=<? echo $assessment_id ?>">SLO # <? echo $slo_num; ?>  <? echo $slo_text;?></a></td>
               			</tr>
               			<?           			
               			}     
    }
?>
</table>
</div>

 <div class="well">
<h2>Institutional</h2>
<table border="1">
                 <?
foreach($dbh->query($inst_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h3>" . $team_name = $row['team_name']  . "</h3></th></tr>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="100"><h4>Create Date</h4></td><td width="130"><h4>Submit Date</h4></td><td width="700"><h4>Expected Outcome</h4></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              foreach($dbh->query("select * from assessment, team_user join users on team_user.user_id=users.user_id where assessment.user_id=users.user_id  AND assessment_period='2015' AND submitted='1' AND team_user.team_id='$team_id'") ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               						
									   $expected_outcome=$assessrow['expected_outcome'];               			
               						 $assessment_id=$assessrow['assessment_id'];    
               						 $username=$assessrow['user_username']; 
               						$fname = $assessrow['user_fname'];
               						$submitted=$assessrow['submitted'];
       								$lname= $assessrow['user_lname'];
       								$create_date= $assessrow['create_date'];
       								$submit_date= $assessrow['submit_date'];
       								$full_name = $fname . " " . $lname;
               						 		
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               			<td><? echo $create_date; ?></td>
               			<td><? echo $submit_date;?></td>
               			<td><a href="report_data.php?id=<? echo $assessment_id ?>"><? echo $expected_outcome;?></a></td>
               			</tr>
               			<?           			
               			}     
    }
?>
</table>
</div>
<? if($admin==1) 
{
?>
  <div class="well">
            <h2 align="center">Saved</h2>
            </div>
               <div class="well">
<h2>Academic</h2>
<table border="1">
                 <?
foreach($dbh->query($saved_acad_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h3>" . $team_name = $row['team_name']  . "</h3></th></tr>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="100"><h4>Create Date</h4></td><td width="700"><h4>Student Learning Objectives</h4></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              
             // foreach($dbh->query("select * from assessment,slo, team_user join users on team_user.user_id=users.user_id where assessment.slo_id=slo.slo_id AND assessment.user_id=users.user_id AND assessment_period='2015' AND  submitted='0' AND assessment.team_id='$team_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow)
               foreach($dbh->query("select * from assessment, slo, team_user join users on team_user.user_id=users.user_id where assessment.slo_id=slo.slo_id AND assessment.team_id=team_user.team_id AND assessment.user_id=users.user_id AND assessment_period='2015' AND submitted='0' AND assessment.team_id='$team_id' order by slo_num") ->fetchAll(PDO::FETCH_ASSOC) as $assessrow)  
               		{
               						
									   $expected_outcome=$assessrow['expected_outcome'];               			
               						 $assessment_id=$assessrow['assessment_id'];    
               						 $username=$assessrow['user_username']; 
               						$fname = $assessrow['user_fname'];
       								$lname= $assessrow['user_lname'];
       								$submitted=$assessrow['submitted'];
       								$create_date= $assessrow['create_date'];
       							
       								$slo_id=$assessrow['slo_id'];
       								$slo_num=$assessrow['slo_num'];
       								$full_name = $fname . " " . $lname;
               					foreach($dbh->query("select slo_text from slo where slo_id='$slo_id'")	 ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
               						{
											$slo_text= $slorow['slo_text'];     						
               						}	
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               			<td><? echo $create_date;?></td>
               			<td><a href="report_data.php?id=<? echo $assessment_id ?>">SLO # <? echo $slo_num; ?>  <? echo $slo_text;?></a></td>
               			</tr>
               			<?           			
               			}     
    }
?>
</table>
</div>

 <div class="well">
<h2>Institutional</h2>
<table border="1">
                 <?
foreach($dbh->query($saved_inst_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h3>" . $team_name = $row['team_name']  . "</h3></th></tr>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="100"><h4>Date</h4></td><td width="700"><h4>Expected Outcome</h4></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              foreach($dbh->query("select * from assessment, team_user join users on team_user.user_id=users.user_id where assessment.team_id=team_user.team_id AND assessment.user_id=users.user_id AND assessment_period='2015' AND submitted='0' AND assessment.team_id='$team_id'") ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
               		{
               						
									   $expected_outcome=$assessrow['expected_outcome'];               			
               						 $assessment_id=$assessrow['assessment_id'];    
               						 $username=$assessrow['user_username']; 
               						$fname = $assessrow['user_fname'];
               						$submitted=$assessrow['submitted'];
       								$lname= $assessrow['user_lname'];
       								$create_date= $assessrow['create_date'];
       								$full_name = $fname . " " . $lname;
               						 		
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td>
               			<td><? echo $create_date; ?></td>
               			<td><a href="report_data.php?id=<? echo $assessment_id ?>"><? echo $expected_outcome;?></a></td>
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
</div> <!-- container -->