<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Sign in</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form class="form-signin" style="max-width: 300px !important; margin-left: 50%; margin-right: 50%; margin:auto;">
        <h2 class="form-signin-heading" >Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control"  placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox" >
          <label>
            <input type="checkbox" value="remember-me"> Remember me?
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="max-width: 148px; display: inline-block;">Sign in</button>
        <button type="button" class="btn btn-default" style="margin-left: 2px !important; padding: 12px 46px !important;">Register</button>
      </form>
    </div>
  </body>
</html>
