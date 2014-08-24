<?php 
/*
 * put this file to /wp-content/maintenance.php
 */
 
// search engines stuff
if ( 'HTTP/1.1' != @$_SERVER["SERVER_PROTOCOL"] && 'HTTP/1.0' != @$_SERVER["SERVER_PROTOCOL"] ) @$_SERVER["SERVER_PROTOCOL"] = 'HTTP/1.0';
header( @$_SERVER['SERVER_PROTOCOL'].' 503 Service Unavailable', true, 503 );
header( 'Content-Type: text/html; charset=utf-8' );
header( 'Retry-After: 600' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sorry! We're doing some routine maintenance.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
 
<div style="width:300px; margin: auto;">
	<h1>We're on a quick coffee break.</h1>
	<p>Our site is undergoing a brief bit of maintenance that will last <strong>5 minutes at the very most</strong>.</p>
	<p>We apologize for the inconvenience, we're doing out best to get things back to working order for you.</p>
</div>
 
<?php
//stop executing the page
die();
?>