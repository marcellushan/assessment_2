<?
// Set user name and password
$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh


echo $username=mhannah;


try {
     //$dbh = new PDO('mysql:host=localhost;dbname=Assessment_2', $wwwuser, $wwwpass);
      $dbh = new PDO("mysql:host=localhost;dbname=Assessment_2', root, 'europe-guilty-kaleidoscope-head"');
    foreach($dbh->query('select users_username, team_name from users as us 
inner join user_team as ut
on us.users_id = ut.users_id
inner join team te
on ut.team_id=te.team_id
where users_username ="mhannah"')  ->fetchAll(PDO::FETCH_ASSOC) as $row) 
    {
         print_r($row);
    }
    //$dbh = null;
    
     $getuser = $dbh->query('SELECT * FROM users');
  $usercheck = $getuser->rowCount();
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Assessment_data</title>
  </head>
  <body>
    <div align="right"><big><big>Office of Strategic Planning,
          Assessment &amp; Accreditation</big></big><br>
    </div>
    <br>
    <br>
    <big><big>Unit:&nbsp;&nbsp;&nbsp; Information Technology Unit<br>
        <br>
        Reported by:&nbsp; Jason McFry<br>
        <br>
        <br>
      </big></big>
    <table border="0" cellpadding="2" cellspacing="2" width="100%">
      <tbody>
        <tr>
          <td valign="top"><big>Unit/Team <br>
              Mission Statement</big></td>
          <td valign="top">
            <meta charset="utf-8">
            The Information Technology Division provides technological
            services that support the computing needs of the
            institutions academic and administrative functions.
            &nbsp;Furthermore, the Information Technology Division
            enhances the teaching and learning process for students,
            faculty and staff by researching, developing, implementing,
            and facilitating diverse and effective delivery systems
            through the use of new technologies.</td>
        </tr>
        <tr>
          <td valign="top">Related<br>
            College<br>
            Goal<br>
          </td>
          <td valign="top"><textarea rows="4" cols="100">ecurity &amp;
              Network Services (ISNS) will provide security-awareness
              training to faculty and staff via development of an
              in-house training portal or purchase of SANS: Securing The
              Human training.</textarea> </td>
        </tr>
        <tr>
          <td valign="top">Expected <br>
            Outcome </td>
          <td valign="top"><textarea rows="4" cols="100">&nbsp; Network
              Services (ISNS) will provide security-awareness training
              to faculty and staff via development of an in-house
              training portal or purchase of SANS: Securing The Human
              training.</textarea><br>
          </td>
        </tr>
        <tr>
          <td valign="top">Outcome<br>
            Assessment<br>
            Method </td>
          <td valign="top"><textarea rows="4" cols="100">Network
              Services (ISNS) will provide security-awareness training
              to faculty and staff via development of an in-house
              training portal or purchase of SANS: Securing The Human
              training.</textarea><br>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <button>Save Assessment</button> <br>
    <br>
    <button>Submit Assessment</button>
  </body>
</html>
