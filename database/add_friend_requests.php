<?php

require '../config.php';

$connect = mysql_connect($db_hostname, $db_username, $db_password);

$db_connect = mysql_select_db($db_db);

$delete_friend_request_sql =   "DELETE FROM friend_combinations";
mysql_query($delete_friend_request_sql);

for($i = 2; $i < 20; $i++ ){

    $user = "user" . $i;
    $insert_friend_request_sql =   "INSERT INTO friend_combinations (requestor_name, receiver_name, are_friends) 
                                    VALUES ( '$user' , 'user1', false)";
    mysql_query($insert_friend_request_sql);
}

mysql_close( $connect );
echo "done\n\n";

?>