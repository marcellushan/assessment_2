<?
include "inc/init.php"; 
 include "inc/header.php"; 
include 'inc/validate.php';

$assessment_id = $_POST['id'];
$username= $_POST['username'];
$email_text=$_POST['email_text'];
$team_name=$_POST['team_name'];
$team_type=$_POST['team_type'];
$team_id=$_POST['team_id'];
$unlock=$_POST['unlock'];
//exit(0);
  // bootstrap header   		

  ?>
            <div class="well">         
 <?        

if($unlock=='1') 
	{
		//Update record with Submit_date and submitted flag
		$sql = "UPDATE assessment SET submitted='0' WHERE assessment_id = '$assessment_id'";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$affected_rows = $stmt->rowCount(); 
		$unlock_text = "The assessment has been opened for editting.";
	user_mail($assessment_id, $username, $email_text, $team_name, $team_type, $team_id, $servername) ;
		
	}
	else 
	{
		locked_mail($assessment_id, $username, $email_text, $team_name, $team_type, $team_id, $servername) ;
	}
?>
<h2>Assessment <? echo $assessment_id ?> has returned to the submitter for modification.</h2>
            <h2>With the following message attached:</h2>
            <h3><? echo $email_text ?><p><? echo $unlock_text ?></h3>
</div>
<div class="well">
<a href="report.php"><h2>Return to Report page</h2></a>
</div>
            </div> <!-- container -->
          
            </body>
            </html>