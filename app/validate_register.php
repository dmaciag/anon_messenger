<?php

session_start();

require "../config.php";
require "../functions.php";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$username = $_POST[username];
$email    = $_POST[email];
$password = $_POST[password_first];
$conf_pas = $_POST[password_second];

$username = strip_data($username);
$email 	  = strip_data($email);
$password = strip_data($password);
$conf_pas = strip_data($conf_pas);

if( $password != $conf_pas ){
	die('Passwords are different');
}

if(	
	empty($username) ||
	empty($email)    ||
	empty($password) 
  ) 
{
	if( !redirect_register() )
	{
		die('something terrible has gone wrong in the registration due to empty arguments');
	}
}

$check_if_exists_user_sql = "SELECT username FROM registered_users WHERE username = \"$username\"";
$registered_users = mysql_query($check_if_exists_user_sql);

if( !$registered_users ){
	$error_mesage  = 'Invalid query error: ' . mysql_error() . "\n";
	$error_mesage .= 'Desired query: ' . $user_pass_sql;
	die( $error_mesage );
}

if( mysql_num_rows($registered_users) >= 1 ){
	$_SESSION['user_already_exists_in_db'] = true;
	if( !redirect_register() ) die( 'Did not redirect to registration from registration properly' );

}
else{
	$_SESSION['user_already_exists_in_db'] = false;
}

$regisitration_sql = "INSERT INTO registered_users (username, email, password)	VALUES ('$username', '$email', '$password')";

if( !mysql_query($regisitration_sql) ) die('Cannot register user to database, error: ' . mysql_error());

$_SESSION['is_logged_in'] = true;

if ( !redirect_messenger() ) die('Did not redirect to messenger from registration properly');

echo "successfuly Registered, but you shouldn't see this\n";

?>