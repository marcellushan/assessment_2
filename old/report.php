<?
session_start();
include 'inc/opendb.php';
$username = $_SESSION['username'];

if (!$_SESSION['username']) {
header("Location: https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/report.php");
exit(0);
}

$getuser = mysql_query("SELECT admin_users_id FROM admin_users WHERE admin_users_username='$username';", $conn3);
$usercheck = mysql_num_rows($getuser);

if (@$usercheck <= 0) {
echo "<div style=\"width: 400px; border: 1px #000 solid; background: #f1f1f1;\">You are not authorized to access this page. Please try logging in <a href=\"https://www.highlands.edu/site/connect/login.php?url=https://www.highlands.edu/site/misc/assessment/form.php\">here</a>.  If this error persists, please contact <a href=\"mailto:rt@highlands.edu\">IT</a> for assistance.</div>";
exit(0);
}

if (!@$_GET['year']) {
$month = date("m");
 if ($month < 10) {
    $periodyear = date("Y") -1;
 }
 else {
    $periodyear = date("Y");
 }
//$periodyear = date("Y");
} else {
$periodyear = @$_GET['year'];
}

?>

<style>
a {
        color: #000000;
        font-size: 14px;
        text-decoration: underline;
        font-weight: bold;
}

a:hover {
        color: #E87511;
        font-weight: bold;
        text-decoration: none
}


</style>

<center>
<table width="1020" cellpadding="5" cellspacing="0" border="0"><tr><td align="left" style="font-size: 28px; font-weight: bold;"></td><td align="right" style="font-size: 20px; font-weight: bold;">Office of Strategic Planning, Assessment, &amp; Accreditation</td></tr></table>
<div style="background: #cecece; padding: 20px; width: 990px; text-align: left; border-bottom: 3px #f58023 solid; border-top: 3px #f58023 solid;border-right: 1px #000000 solid;border-left: 1px #000000 solid;">

<table width="980" cellpadding="5" cellspacing="0" border="0">
<tr>

<!-- td valign="top" width="200" align="center"><img src="https://www.highlands.edu/images/shield_logo_ds.png" /></td -->

<td valign="top">
<b style="font-size: 20px;">Assessment Reports</b>&nbsp;&nbsp;
<?
$getyears = mysql_query("SELECT DISTINCT(assessment_period) FROM assessment ORDER BY assessment_period DESC;", $conn3);
while($rowgetyears = mysql_fetch_array($getyears, MYSQL_ASSOC)) {
$years = $rowgetyears['assessment_period'];
?>
<?
if (@$years == $periodyear) {
?>
<b style="font-size: 14px; color: red;"><? echo @$years; ?></b>&nbsp;&nbsp;
<? } else { ?>
<a href="report.php?year=<? echo @$years; ?>"><? echo @$years; ?></a>&nbsp;&nbsp;
<? } ?>
<?
}
?>

<div style="width: 950px; background: #f1f1f1; padding: 10px; border: 1px #000000 solid;">
<table width="950" cellpadding="5" cellspacing="0" border="0">

<tr><td style="border-bottom: 1px #000000 solid;"><b>Unit/Team</b></td><td style="border-bottom: 1px #000000 solid;"><b>Reported By</b></td><td style="border-bottom: 1px #000000 solid;"><b>Assessment Period</b></td><td style="border-bottom: 1px #000000 solid;"><b>Submit Date</b></td><td style="border-bottom: 1px #000000 solid;"><b>Print</b></td></tr>

<?
$getassessment = mysql_query("SELECT * FROM assessment WHERE assessment_period='$periodyear' ORDER BY submit_datetime;", $conn3);
while($rowgetassessment = mysql_fetch_array($getassessment, MYSQL_ASSOC)) {
$assessment_id = $rowgetassessment['assessment_id'];
$unit_team = $rowgetassessment['unit_team_name'];
$users_name = $rowgetassessment['users_fname'] . " " . $rowgetassessment['users_lname'];
$assessment_period = $rowgetassessment['assessment_period'];
$submit_date = $rowgetassessment['submit_datetime'];
$submit_date = date('m/d/Y', strtotime($submit_date));
?>


<tr><td><a href="form.php?admin=1&id=<? echo @$assessment_id; ?>"><? echo @$unit_team; ?></a></td><td><? echo @$users_name; ?></td><td><? echo @$assessment_period; ?></td><td><? echo @$submit_date; ?></td><td><a href="print_form.php?admin=1&id=<? echo @$assessment_id; ?>" target="_new"><img src="printer.png" border="0"></a></td></tr>

<? } ?>

</table>
</form>

</div>

</div>

</center>

<br /><br />
