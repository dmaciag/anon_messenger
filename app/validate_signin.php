<?php

require "./../config.php";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$email = $_POST[email];
$email = stripslashes($email);

$password = $_POST[password];
$password = stripslashes($password);

$user_pass_sql = "SELECT username, password FROM registered_users WHERE username = \"$email\"";
$registered_users = mysql_query($user_pass_sql);

if( !$registered_users ){
	$error_mesage  = 'Invalid query error: ' . mysql_error() . "\n";
	$error_mesage .= 'Desired query: ' . $user_pass_sql;
	die( $error_mesage );
}

if( mysql_num_rows($registered_users) == 1 ){
	
	$user = mysql_fetch_assoc($registered_users);

	if( $user["username"] == $email && $user["password"] == $password ){
		echo "Welcome, $email !";
		
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