<?php

$email = $_POST[email];
$password = $_POST[password];

mysql_connect('localhost', 'root' , '' , 'my_db');

echo $email . '<br>' . $password . '<br>';
echo "Sign In";

?>