<?

// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh


$username='mhannah';

     $dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
     //$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head');
    foreach($dbh->query("SELECT * FROM users where users_usersname='$username'") ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
         //print_r($row);
          echo $row['users_lname'];
    }

 //$getuser = $dbh->query("SELECT * FROM users where users_usersname='$username'");
  //echo $getuser['users_usersname'];  
  //$usercheck = $getuser->rowCount();
  //echo $usercheck;

 ?>
 
 