<?php
  session_start();
  require '../functions.php';
  if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the messenger page.');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Messenger</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/messenger.css" type="text/css" rel ="stylesheet">
    <script>
      function display_friend(str) {
          if (str == "") {
              document.getElementById("friend_search").innerHTML = "";
              return;
          } else {
              if (window.XMLHttpRequest) {
                  xml_http = new XMLHttpRequest();
              } else {
                  xml_http = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xml_http.onreadystatechange = function() {
                  if (xml_http.readyState == 4 && xml_http.status == 200) {
                      document.getElementById("friend_search").innerHTML = xml_http.responseText;
                  }
              };
              xml_http.open("GET","friend_search.php?friend_input="+str,true);
              xml_http.send();
          }
      }
    </script>
  </head>
  <body>
    <?php echo "Welcome : " . $_SESSION['username'] . "<br>"; ?>
    <form id="messenger_search">
    <input type="text" size="20" onkeyup="display_friend(this.value)">
    <div id="friend_search"></div>
    </form>
    <button id="logout_button" onclick="window.location.href='./logout.php'" type="button" class="btn btn-default">Log Out</button>
  </body>
</html>
