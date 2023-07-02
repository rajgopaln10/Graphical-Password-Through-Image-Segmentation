<?php
// shows no warning/warning on production
error_reporting(0);

//set database information
	$databasehost='localhost';
	$databasename='labon_image';
	$databaseusername='root';
	$databasepassword='';
//connect to database
 $db = mysqli_connect($databasehost, $databaseusername, $databasepassword, $databasename);

if (!$db) {
    die(mysqli_error($db));
	exit();
}

?>