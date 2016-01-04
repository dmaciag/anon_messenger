<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form class="form-signin" action="./validate_register.php" method="post" style="max-width: 300px !important; margin-left: 50%; margin-right: 50%; margin:auto;">
        <h2 class="form-signin-heading" >Please Register</h2>
        Name: 
        <label for="first_name" class="sr-only">First</label>
        <input type="text" name="first_name" id="first_name" style="margin-bottom: 4px;" class="form-control"  placeholder="First" required>
        <label for="last_name" class="sr-only">Last</label>
        <input type="text" name="last_name" id="last_name" style="margin-bottom: 4px;" class="form-control"  placeholder="Last" required>        
        Create a password: 
        <label for="inputPassword_first" class="sr-only">Password</label>
        <input type="password" name="password_first" id="inputPassword_first" class="form-control" placeholder="Password" required>
        Confirm your password: 
        <label for="inputPassword_second" class="sr-only">Confirm Password</label>
        <input type="password" name="password_second" id="inputPassword_second" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="max-width: 300px; display: inline-block;">Register</button>
      </form>
    </div>
  </body>
</html>
