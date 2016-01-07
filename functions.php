<?php

function redirect_signin(){
	return header("Location: http://localhost/app/signin.php");
}

function redirect_messenger(){
	return header("Location: http://localhost/app/messenger.php");
}

function redirect_register(){
	return header("Location: http://localhost/app/register.php");
}

function strip_data( $data_to_be_stripped ){

	$data_to_be_stripped = 	trim($data_to_be_stripped);
	$data_to_be_stripped = 	stripslashes($data_to_be_stripped);
	$data_to_be_stripped = 	htmlspecialchars($data_to_be_stripped);
	$data_to_be_stripped = 	mysql_real_escape_string($data_to_be_stripped);
 
	return $data_to_be_stripped;
}

?>