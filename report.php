<?
include "inc/init.php"; 
 include "inc/header.php";
 ?>
<!DOCTYPE html>
<?

	$acad_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='0' AND assessment_period='2015' AND submitted='1' order by team_name";
	$inst_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='1' AND assessment_period='2015' AND submitted='1' order by team_name";
	$saved_acad_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='0' AND assessment_period='2015' AND submitted='0' order by team_name";
   $saved_inst_team_sql = "select distinct team_name, team.team_id from assessment, team where assessment.team_id=team.team_id AND team_type='1' AND assessment_period='2015' AND submitted='0' order by team_name";


 ?>
            <div class="well">
            <h1 align="center"><a href="index.php">Facilitators Login HERE</a></h1>
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
            <h2 align="center">Submitted Reports</h2>
            </div>
                        <div class="well">
<h2>Academic Teams</h2>
<table border="1">
                 <?
foreach($dbh->query($acad_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h3>" . $team_name = $row['team_name']  . "</h3></th></tr>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="100"><h4>Course</h4></td><td width="600"><h4>Student Learning Objectives</h4></td></tr>
    	   <?
    	 $team_id = $row['team_id'];
              foreach($dbh->query("select * from assessment,slo,team, users where assessment.team_id='$team_id' and assessment.slo_id=slo.slo_id AND submitted='1'and team.team_id=assessment.team_id and assessment.user_id=users.user_id")  ->fetchAll(PDO::FETCH_ASSOC) as $assessrow) 
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
       								$slo_text= $assessrow['slo_text'];   
       								$course=$assessrow['course'];
       								$full_name = $fname . " " . $lname;
               					//foreach($dbh->query("select slo_text from slo where slo_id='$slo_id'")	 ->fetchAll(PDO::FETCH_ASSOC) as $slorow) 
               					//	{
									//		$slo_text= $slorow['slo_text'];     						
               					//	}	
               			?>  
               			<tr>
               			<td><? echo $full_name;?></td> 
               			<td><? echo $course;?></td>              			
               							<td><a href="report_data.php?id=<? echo $assessment_id ?>"><? echo $slo_text;?></a></td>
               			</tr>
               			<?           			
               			}     
    }
?>
</table>
</div>

 <div class="well">
<h2>Administrative Units</h2>
<table border="1">
                 <?
foreach($dbh->query($inst_team_sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {  $i= 0;
    	echo "<tr><th colspan='4'><h3>" . $team_name = $row['team_name']  . "</h3></th></tr>";
    	?>
    	   <tr><td width="200"><h4>Creator</h4></td><td width="700"><h4>Expected Outcome</h4></td></tr>
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
               							<td><a href="report_data.php?id=<? echo $assessment_id ?>"><? echo $expected_outcome;?></a></td>
               			</tr>
               			<?           			
               			}     
    }
?>
</table>
</div>


</div> <!-- container -->
