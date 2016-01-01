<?php

$hostname = "localhost";
$username = "root";
$password = "root";
$db = "my_db";

mysql_connect("$hostname", )

$email = $_POST[email];
$password = $_POST[password];

$sql = "SELECT username, password FROM registered_users WHERE username = \"$email\"";
$registered_users = $conn->query($sql);

if($registered_users->num_rows == 1 ){
	$user = $registered_users->fetch_assoc();
	if($user["username"] == $email && $user["password"] == $password){
		echo "Welcome, $email !";
	}
	else{
		echo "Invalid password !";
	}
}
else{
	echo "User is not registered. " .'<br>';
}

$conn->close();


?>