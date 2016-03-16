<?php

session_start();

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the add_friend page.');
}

$message_data = json_decode(file_get_contents('php://input'),true);

$message  = $message_data['message'];
$receiver = $message_data['friend'];
$sender   = $_SESSION['username'];
// $date_created = $message_data['date_created'];
$date_created = date("Y-m-d h:i:sa");

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$insert_message_sql = 
"INSERT INTO messages   (message,    date_created,    sender,    receiver)
 VALUES      		  ('$message', '$date_created', '$sender', '$receiver')";

$insert_message = mysql_query($insert_message_sql);

if(!$insert_message) die('Failed to send message');

mysql_close($connect);

?>