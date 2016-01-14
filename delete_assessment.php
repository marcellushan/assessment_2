<?
include "inc/init.php"; 
include 'inc/validate.php';

//Capture Assessment ID from url variable id
$assessment_id = $_GET["id"];



//Delete assessment
$sql = "DELETE FROM assessment  WHERE assessment_id='$assessment_id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$affected_rows = $stmt->rowCount();

 ?>
      <html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=report.php?admin=1">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
