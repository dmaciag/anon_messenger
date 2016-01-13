<?php

session_start();

require "./../config.php";
require "../functions.php";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$username = $_POST[username];
$password = $_POST[password];

$username = strip_data($username);
$password = strip_data($password);

$user_pass_sql = "SELECT username, password FROM registered_users WHERE username = \"$username\"";
$registered_users = mysql_query($user_pass_sql);

if( !$registered_users ){
	$error_mesage  = 'Invalid query error: ' . mysql_error() . "\n";
	$error_mesage .= 'Desired query: ' . $user_pass_sql;
	die( $error_mesage );
}

if( mysql_num_rows($registered_users) == 1 ){
	
	$user = mysql_fetch_assoc($registered_users);

	if( $user["username"] == $username && $user["password"] == $password ){
		$_SESSION['is_logged_in'] = true;
		$_SESSION['username'] = $username;
		if( !redirect_messenger() ) die( 'did not redirect to messenger from signin' );
	}
	else{
		echo "Invalid password !";
	}
}
else{
	echo "User is not registered. " .'<br>';
}

mysql_close($connect);

?>