<?php

// development environments

function devEnv(){
	require 'config.php';
	return  $mac ? '' : '/anon_messenger';
}
function redirect_signin(){
	$app_name = devEnv();
	return header("Location: http://localhost$app_name/php/signin.php");
}

function redirect_messenger(){
	$app_name = devEnv();
	return header("Location: http://localhost$app_name/php/messenger.php");
}

function redirect_register(){
	$app_name = devEnv();
	return header("Location: http://localhost$app_name/php/register.php");
}

function strip_data( $data_to_be_stripped ){

	$data_to_be_stripped = 	trim($data_to_be_stripped);
	$data_to_be_stripped = 	stripslashes($data_to_be_stripped);
	$data_to_be_stripped = 	htmlspecialchars($data_to_be_stripped);
	$data_to_be_stripped = 	mysql_real_escape_string($data_to_be_stripped);
 
	return $data_to_be_stripped;
}

?>