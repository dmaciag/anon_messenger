<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form id="form_check_password" class="form-signin" action="./validate_register.php" method="post" style="max-width: 300px !important; margin-left: 50%; margin-right: 50%; margin:auto;">
        <h2 class="form-signin-heading" >Enter information</h2>
        <?php 
              require '../config.php'; 
              if( $user_exists_already ) {
                  $user_exists_already = false;
                  echo 'User already exists'; 
              }
        ?>
        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" style="margin-bottom: 4px;" class="form-control"  placeholder="Username" required>
        <label for="last_name" class="sr-only">Email</label>
        <input type="email" name="email" id="email" style="margin-bottom: 4px;" class="form-control"  placeholder="Email" required>
        <label for="inputPassword_first" class="sr-only">Password</label>
        <input type="password" name="password_first" id="inputPassword_first" style="margin-bottom: 4px;" class="form-control" placeholder="Password" required>
        <label for="inputPassword_second" class="sr-only">Confirm Password</label>
        <input type="password" name="password_second" id="inputPassword_second" style="margin-bottom: 4px;" class="form-control" placeholder="Confirm Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="max-width: 300px; display: inline-block;">Register</button>
      </form>   
    </div>
<script type="text/javascript">
$("#form_check_password").validate({
  rules: {
                    password_first: { 
                    required: true,
                    minlength: 3,
                    maxlength: 40,

               } , 
                    password_second: { 
                    equalTo: "#inputPassword_first",
                    minlength: 3,
                    maxlength: 40,
               }
           },
    messages: {
      password: {
        required: "the password is required"
      }
    }
});
</script>   
  </body>
</html>
