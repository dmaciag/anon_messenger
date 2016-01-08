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
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script>
      function display_friend(str) {
          if (str == "") {
              document.getElementById("friend_search").innerHTML = "";
              return;
          } else {
              if (window.XMLHttpRequest) {
                  // code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttp.onreadystatechange = function() {
                  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                      document.getElementById("friend_search").innerHTML = xmlhttp.responseText;
                  }
              };
              xmlhttp.open("GET","friend_search.php?q="+str,true);
              xmlhttp.send();
          }
      }
    </script>
  </head>
  <body>
    <?php echo "Welcome : " . $_SESSION['username'] . "<br>"; ?>
    <form>
    <input type="text" size="20" onkeyup="display_friend(this.value)">
    <div id="friend_search"></div>
    </form>
    <button onclick="window.location.href='./logout.php'" type="button" class="btn btn-default" style="margin-left: 2px !important; padding: 12px 46px !important;">Log Out</button>
  </body>
</html>
