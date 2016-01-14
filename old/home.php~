<html>

<?php

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

echo $username='mhannah';

     $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
     // $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
   // foreach($dbh->query("select * from users where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
      foreach($dbh->query("select users_fname, users_lname, team_name, team_mission_statement from users as us
															inner join user_team as ut
															on us.users_id = ut.users_id
															inner join team te
															on ut.team_id=te.team_id where users_username='$username'")  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
        //print_r($row);
       $fname = $row['users_fname'];
        $lname= $row['users_lname'];
       $team = $row['team_name'];
     
    }
    $reassess = $dbh->query("select * from assessment where reassessment = '2'");
   // echo $row_count = $reassess->rowCount();
   $row = $reassess->fetch();
    if(!$row) { 
    
    echo "reassess";
    
 }
    
//echo $unit_team = $row['unit_team_name'];
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link type="text/css" href="download-style.css" />
    <link type="text/css" href="text-toolbar.css" rel="stylesheet" />
</head>
<body>
    <div style="background-image:url('data:image/jpg;base64,');width:800px;left:140px;background-repeat:no-repeat;height:1070px;">
        
        <div class="TEXT text-bold text-center" style="z_index: 1000; top: 25px; height: 27.6666666269; width: 217.666666627; position: absolute; left: 280px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        GHC  Assessment
                    
                </p>
            
        </div>
        
        <div class="BUTTON " style="z_index: 1000; top: 670px; height: 27.6666666269; width: 187.666666627; position: absolute; left: 15px; ">
            
                <button  style="width: 100%; height:100%;"  onclick="window.location.href='create.html'">
                    
                        Create New Assessment
                    
                </button>
            
        </div>
        
        <div class="LINK " style="z_index: auto; top: 420px; height: 17.6666666269; width: 163.666666627; position: absolute; left: 20px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="edit.html" >
                    
                        Provide Reliable Service
                    
                </a>
            
        </div>
        
        <div class="LINK " style="z_index: auto; top: 460px; height: 17.6666666269; width: 107.666666627; position: absolute; left: 20px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="edit.html" >
                    
                        Update Security
                    
                </a>
            
        </div>
        
        <div class="TEXT text-left text-bold" style="z_index: auto; top: 370px; height: 27.6666666269; width: 142.666666627; position: absolute; left: 20px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        Saved Assessments
                    
                </p>
            
        </div>
        
        <div class="LINK " style="z_index: auto; top: 560px; height: 17.6666666269; width: 162.666666627; position: absolute; left: 15px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="view.html" >
                    
                        Provide Reliable Service
                    
                </a>
            
        </div>
        
        <div class="LINK " style="z_index: auto; top: 600px; height: 17.6666666269; width: 106.666666627; position: absolute; left: 15px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="view.html" >
                    
                        Update Security
                    
                </a>
            
        </div>
        
        <div class="TEXT text-left text-bold" style="z_index: 1000; top: 130px; height: 33.6666666269; width: 227.666666627; position: absolute; left: 20px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        Unit: <? echo $team ?>
                    
                </p>
            
        </div>
        
        <div class="TEXT text-left text-bold" style="z_index: auto; top: 510px; height: 27.6666666269; width: 176.666666627; position: absolute; left: 15px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        Submitted Assessments
                    
                </p>
            
        </div>
        
        <div class="TEXT text-left text-bold" style="z_index: 1000; top: 185px; height: 27.6666666269; width: 227.666666627; position: absolute; left: 20px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        Reported by:  <? echo $fname.' '.$lname ?>
                    
                </p>
            
        </div>
        
        <div class="LINK " style="z_index: 1000; top: 280px; height: 17.6666666269; width: 163.666666627; position: absolute; left: 20px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="reassess.html" >
                    
                        Provide Reliable Service
                    
                </a>
            
        </div>
        
        <div class="LINK " style="z_index: 1000; top: 320px; height: 17.6666666269; width: 107.666666627; position: absolute; left: 20px; ">
            
                <a  style="padding: 2px; width: 100%; height:100%;"  href="reassess.html" >
                    
                        Update Security
                    
                </a>
            
        </div>
    <? $reassess = $dbh->query("select * from assessment where reassessment = '1'");
    echo $row_count = $reassess->rowCount();
    if($row_count > '0') { ?>
    
     <div class="TEXT text-left text-underline text-bold" style="z_index: 1000; top: 230px; height: 27.6666666269; width: 127.666666627; position: absolute; left: 20px; ">
            
                <p  style="padding: 2px; width: 100%; height:100%;" >
                    
                        Re-Assessments
                    
                </p>
            
        </div>
    

    
 <? } ?>       
        
                
    </div>
</body>
</html>