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
      function display_friend( entry ){
        if( entry.length == 0 ){
          document.getElementById("friend_search").innerHTML="";
          document.getElementById("friend_search").style.border="0px";
          return;
        }
        if( window.XMLHttpRequest ){
          xml_http = new XMLHttpRequest();
        }
        else{
          // not supporting sub ie7
          return;
        }

        xml_http.onreadystatechange = function(){
          if( xml_http.readyState == 4 && xml_http.status == 200 ){
            document.getElementById().innerHTML = xml_http.responseText;
            document.getElementById().style.border= "1px solid #0f0";
          }
        }

        xml_http.open("GET","friend_search.php?q="+entry, true);
        xml_http.send();
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
