<?
// Database connection
include "inc/init.php"; 

include 'inc/validate.php';

//Select all teams
$sql= "SELECT * FROM team order by team_name";

//Select all users
$users_sql= "SELECT *, concat(user_fname, ' ',user_lname) as full_name FROM users where inactive='0' order by user_lname";

//Assign variables from url parameters
$team_id=$_GET['team_id'];
$team_name=$_GET['team_name'];
$user_id=$_GET['user_id'];
$full_name=$_GET['full_name'];

//Build user list by team

$team_sql= "select *, concat(user_fname, ' ',user_lname) as full_name from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where te.team_id='$team_id'";

//Build team list by user
$user_team_sql= "select * from users as us inner join team_user as ut on us.user_id = ut.user_id inner join team te on ut.team_id=te.team_id where us.user_id='$user_id'";

?>
<html lang="en">
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>User Management</title>

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
                <p style="font-weight: bold;">User Management</p>
            </div>
          <div class="well">   
	          <h3>Add New User</h3>
				<form action="new_user.php" method="post">       
          		<div>
          				<div>First Name</div>
          				<div><input type="text" name="first_name" size="20" value="" required /> </div>
          	 </div>
       	  	<div>
          				<div>Last Name </div>
          				<div><input type="text" name="last_name" size="20" value="" required /> </div>
          	 <div>
          				<div>User Name</div>
          				<div><input type="text" name="username" size="20" value="" required /> </div>
          	 </div>
          <input type="submit" name="user_btn" value="Add User" />
          </form>   
          </div>  
              <div class="well">   
          <h3>Add Existing User to a Team</h3>  
          <select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
            <option>Select User Name</option>
<?
foreach($dbh->query($users_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row3) 
				{ 	
				?>
				<option value="add_to_team.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
          </div>
          
              <div class="well">   
           <h3>Deactivate a User</h3>  
                     <select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
                     <option>Select User Name</option>
<?
foreach($dbh->query($users_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row3) 
				{ 	
				?>
				<option value="deactivate_user.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
          </div>
          
     <div class="well">
     <h2>Team Membership</h2>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<option>Select Team Name</option>
<?
foreach($dbh->query($sql) ->fetchAll(PDO::FETCH_ASSOC) as $row) 
				{ 	
				?>
				<option value="team.php?team_id=<? echo $row['team_id']; ?>&team_name=<? echo $row['team_name']; ?>" ><? echo $row['team_name']; ?></option>
				<?
				}
				?>
</select>
<br>
<br>

<?
if($_GET['team_id'])
	{
		
					echo "<h3>" . $team_name . "</h3>";
				echo "<br>";
		foreach($dbh->query($team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row2) 
		{
			echo $row2['full_name'];
			echo "<br>";
		}

	}
?>
</div>
 <div class="well">
<h2>User Membership</h2>
<select id="selectbox" name="team" onchange="javascript:location.href = this.value;">
<option>Select User Name</option>
<?
foreach($dbh->query($users_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row3) 
				{ 	
				?>
				<option value="user.php?user_id=<? echo $row3['user_id']; ?>&full_name=<? echo $row3['full_name']; ?>" ><? echo $row3['full_name']; ?></option>
				<?
				}
				?>
</select>
<br>
<br>

<?
if($_GET['user_id'])
	{
		
					echo "<h3>" . $full_name  . "</h3>";
				echo "<br>";
		foreach($dbh->query($user_team_sql) ->fetchAll(PDO::FETCH_ASSOC) as $row4) 
		{
			echo $row4['team_name'];
			echo "<br>";
		}

	}
?>
</div>
<div class="well">
<h2>Team Lists</h2>
<a href="user_report.php?team_type=0"><h3> Academic Teams</h3></a>  
<a href="user_report.php?team_type=1"><h3> Administrative Teams</h3></a>  

</div>
</div> <!-- container -->
<!-- Validation Script  -->
<script> $.validate(); </script>
</body>
</html>