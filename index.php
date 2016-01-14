<?
include "inc/init.php"; 
include "inc/header.php"; 
include 'inc/validate.php';


//Assign the SESSION to $username
//$username=$_SESSION['username'];


$sql ="select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where user_username='$username'";


//Assign values to variables from the user and team tables
foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row)														
    {
       $fname = $row['user_fname'];
       $lname= $row['user_lname'];
       $user_id = $row['user_id'];
       $team_name = $row['team_name'];
       $full_name = $fname . " " . $lname;
       $team_id = $row['team_id'];
       $team_type = $row['team_type'];
       
 // count how many teams the user is a member of
       @++$i;  
    }
    
// if user is a member of more than one team, then set list session variable to 1, otherwise set it to 0
    if($i >1) {
    				$_SESSION['list']=1;
    			}
    			else {
    				$_SESSION['list']=0;
    			}
    
   //Assign team, name and team_type variables to the session 
    $_SESSION['team_name']=$team_name;
    $_SESSION['full_name']=$full_name;
    $_SESSION['team_type'] = $team_type;
    
    
// if the pickteam url parameter exists, set it to the team_id
  if(@$_GET['pickteam']) 
  	{
  	$team_id = $_GET['pickteam'];
 //assign the team_id to the session
  	$_SESSION['team_id']=$team_id;
  	
  // use the pickteam variable to set the team, assign the team_name to the SESSION
 	foreach($dbh->query("select * from team where team_id='$team_id'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
  		 {
  		 $team_name = $row['team_name'];
  		     $_SESSION['team_name']=$team_name;
  		  //   $last_year = $row2['last_year'];
  		 }
  	}
  	
 ?>
            <div class="well">
                        <legend>This site is used for creating, updating and submitting annual assessments.</legend>
                        <!--Background Information-->
                         <h3 style="color: #004990;">Name : <? echo $full_name; ?> </h3> 
              </div>                        
   <? 
   
   
    // if user is member of more than one team and the pickteam variable is NULL, load links that set the team_id
 if($i > 1 and !@$_GET['pickteam'])
		{ ?>	
	 		<div class="well">         
			<?  foreach($dbh->query($sql)  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
		 		{
		 			if($row['team_type']==0) 
			 			{
			 				echo $team = "<a href='acad_index.php?pickteam=" . $row['team_id']. "'><h3>" . $row['team_name'] . "</h3></a>";
			 			}
		 			else 
			 			{
			 			  echo $team = "<a href='admin_index.php?pickteam=" . $row['team_id']. "'><h3>" . $row['team_name'] . "</h3></a>";
			 			}
		 		}

?> </div> <?
		}

else 

// if user is a member of only one team, redirect to the appropriate home page
		{ 	
			if($team_type==0) 
		 			{
		 				header("Location: acad_index.php?pickteam=$team_id"); /* Redirect browser */
		 			}
	 			else 
		 			{
		 			 header("Location: admin_index.php?pickteam=$team_id"); /* Redirect browser */
		 			 exit();
		 			}
  		} ?>
   </div>
   </div>
   </body>
   </html>
   
