<?php

require "./../config.php";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

if( !isset($_POST[nickname]) ) die('unset nickname');

$username = $_POST[nickname];
$email    = $_POST[email];
$password = $_POST[password_first];


$regisitration_sql = "INSERT INTO registered_users (username, email, password)
						VALUES ('$username', '$email', '$password')";
if( !mysql_query($regisitration_sql) ) die('Cannot register user to database, error: ' . mysql_error());

echo "successfuly Registered.\n";

?>