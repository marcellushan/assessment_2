<?
session_start();
echo $_SESSION['username'];
?>

<html>
  <head>
    <title>IU Webmaster redirect</title>
    <META http-equiv="refresh" content="0;URL=https://forms.highlands.edu/assessment_2/index.php?username=<? echo $_SESSION['username'] ?>">
  </head>
  <body bgcolor="#ffffff">

  </body>
</html>
