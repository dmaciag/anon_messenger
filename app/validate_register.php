<?php

require "./../config.php";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

function strip_data( $data_to_be_stripped ){

	$data_to_be_stripped = 	trim($data_to_be_stripped);
	$data_to_be_stripped = 	stripslashes($data_to_be_stripped);
	$data_to_be_stripped = 	htmlspecialchars($data_to_be_stripped);
	$data_to_be_stripped = 	mysql_real_escape_string($data_to_be_stripped);

	return $data_to_be_stripped;
}

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

if(	empty($username) || 
	empty($email) || 
	empty($password) 
  ) 
{
	if( !header("Location: http://localhost/app/register.php") )
	{
		die('something terrible has gone wrong in the registration due to empty arguments');
	}
}

$regisitration_sql = "INSERT INTO registered_users (username, email, password)	VALUES ('$username', '$email', '$password')";

if( !mysql_query($regisitration_sql) ) die('Cannot register user to database, error: ' . mysql_error());

echo "successfuly Registered.\n";

?>