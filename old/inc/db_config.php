<?php

// DB credentials file added 3/3/09 ss
// Updated - mjh 3/26/15
// Do not modify this file

// Also need to update credentials here \\vault\c$\phone\Database_Path.asp for phone system to work and on tracker for the projects page to pull tickets properly: - ss 1/2/13

// Hypnotoad server mysql credentials:
//$wwwuser = "stephen";
#$wwwpass = "questions-overtime-recognition-outlook"; // last updated 1/2/13 ss
//$wwwpass = "salesman-stocking-ridiculous-regional"; // last updated 11/8/13 rd

// WebDev server mysql credentials
//$wwwuser = 'mhannah';
//$wwwpass = 'bless-certainly-custody'; // last updated 03/26/15 mh

$wwwuser = 'root';
$wwwpass = 'europe-guilty-kaleidoscope-head'; // last updated 03/26/15 mh

// Mail server mysql credentials:
$mailuser = "root";
$mailpass = "presume-latitude-pizza-plans";



// NS server mysql credentials: no longer used
//$nsuser = "stephen";
//$nspass = "ssjs06ms06js08"; // last updated 3/3/09 ss

// Shoudn't have to edit below here:

//WebDev server hostname
$dbhost = 'localhost';
// $dbhost = 'www.highlands.edu';
$dbuser = $wwwuser;
$dbpass = $wwwpass;
$dbpasswd = $wwwpass; // for phpBB

//Tracker mysql credentials:
$trackerhost = "tracker.highlands.edu";
$trackeruser = $wwwuser;
$trackerpass = $wwwpass; // last updated 3/3/09 ss

$dbhost2 = 'mail.highlands.edu';
$dbuser2 = $mailuser;
$dbpass2 = $mailpass;

$dbhost3 = 'www'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser3 = $wwwuser;
$dbpass3 = $wwwpass;

//No longer used - ss 1/18/12
//$dbhost4 = 'ns.highlands.edu';
//$dbuser4 = $nsuser;
//$dbpass4 = $nspass;

$dbhost5 = '168.30.218.15'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser5 = $wwwuser;
$dbpass5 = $wwwpass;

$dbhost6 = 'localhost'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser6 = $wwwuser;
$dbpass6 = $wwwpass;

$dbhost7 = 'localhost'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser7 = 'itorientation';
$dbpass7 = 'limitationscarcelyintensitygoal';

$dbhost8 = 'localhost'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser8 = 'itoncall';
$dbpass8 = 'expenditurepassiveappealpermit';

$dbhost9 = 'localhost'; // necessary for multiple connections to same mysql server but different databases within one script
$dbuser9 = 'osstats';
$dbpass9 = 'scenerywalkreproductionmanage';

$dbuser_office365 = 'office365';
$dbpass_office365 = 'thrill-exceed-assumption-lyrics';
?>
