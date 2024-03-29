<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('America/Los_Angeles');

// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'ecom';

// Database Username
$dbuser = 'root';

// Database Password
$dbpass = '';

// Defining base url
define("BASE_URL", "");

// Getting Admin url
define("ADMIN_URL", BASE_URL . "admin" . "/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}

// server connection
$ftpHost = 'ftp.textronic.info';
$ftpUsername = 'u285599538';
$ftpPassword = 'Tds#Infra@2024';
$ftpDirectory = '/domains/textronic.info/public_html/api_jewellery/api/Brand/';

// Connect to FTP server
$ftpConnection = ftp_connect($ftpHost);
$login = ftp_login($ftpConnection, $ftpUsername, $ftpPassword);

// Check connection
if (!$ftpConnection || !$login) {
    die('FTP connection failed');
}