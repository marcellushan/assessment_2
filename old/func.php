<?php

function  create_list ($string1, $string2)
	 {
	echo $string2;  			
  			$reassess = $dbh->query($string2);
   			echo $row = $reassess->fetch();	
   			
	 	
       if($row) 
       	{ 
    		   echo $string1;
			 }	
		 else 
 			{
 				echo "<h3>Reassessment</h3>";	
 				foreach($dbh->query($string2) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
					{
						?>
						<a href='reassess.php?id=<? echo $row["assessment_id"]; ?>'><? echo $row['expected_outcome']; ?></a>
						<?
						echo "<br>";
	        echo $string1;
 
						}
 				}		
	 }
	
	
// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

$username='mhannah';

     $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
     // $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
   // foreach($dbh->query("select * from users where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
      foreach($dbh->query("select * from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        //print_r($row);
        $users_id = $row['users_id'];
        $fname= $row['users_fname'];
       $lname= $row['users_lname'];
       $team = $row['team_name'];
     
    }
    
      $reassessment_sql = "select expected_outcome, assessment_id from assessment where users_id = '$users_id' AND ReAssessment='1'"; 
      //echo $reassessment_sql;
 create_list("reassessment",$reassessment_sql);

?>