<?php

/* 
 * Connect to DB using PHP PDO
 * TODO add in SSL and encryption methods
 */

date_default_timezone_set('UTC');

// PHP PDO globalize connection string
global $dbh;
// Connection parameters
$user = "incidentreport";
$pass = "ebony-through-dinner-button";
$host = "localhost";
$dbname = "incidentreporting";
// Set Database Handle 
$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
