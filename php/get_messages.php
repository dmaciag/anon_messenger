<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the messenger page.');
}

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$username = strip_data($_SESSION['username']);

$friend_data = json_decode( file_get_contents('php://input') , true);
$friend_username = $friend_data['friend'];

$all_messages_sql= 
"SELECT message, date_created, id, sender
 FROM   messages
 WHERE  (receiver  = '$friend_username'
 AND    sender     = '$username')
 OR 	(receiver  = '$username'
 AND    sender     = '$friend_username')";
 

$all_messages_data   = mysql_query( $all_messages_sql );
$all_messages   = array();

while( $all_message_data = mysql_fetch_assoc($all_messages_data) ){
	$message['sender']          = ($username === $all_message_data['sender']) ? 'current_user' : 'friend';
	$message['id']              = $all_message_data['id'];
	$message['message']         = $all_message_data['message'];
	$message['date_created']    = $all_message_data['date_created'];
	array_push($all_messages, $message);
}

$latest_message_sql  = "SELECT id FROM messages ORDER BY id DESC LIMIT 1";
$latest_message      = mysql_query( $latest_message_sql );
$latest_message_data = mysql_fetch_assoc( $latest_message );
$latest_message_id   = $latest_message_data['id'];

$POST_contents = array('all_messages' => $all_messages, 'latest_message_id' => $latest_message_id );

echo json_encode($POST_contents);

?>