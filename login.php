<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <?php
  // Login check
  session_start();
  if($_SESSION)
  {$user = $_SESSION['user'];}
  ?>

  <body>
    <?php  include 'navbar.php';
      echo "<br>";
    ?>
    <form action="_session.php" method="POST" id='form'></form>
    <div class="container-fluid">
      <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 text-center">
          <h2>Login</h2><br>
        </div>
        <div class="col-4">
        </div>
      </div>
      <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 bg-light" id="box">
          <br>

          <div class="row">
            <div class='input-group'>
            <div class='col-3'>
            <div class='input-group-prepend'>
              <span class='input-group-text' id=''>Username</span>
            </div>
            </div>
            <div class='col-9'>
            <input class='form-control' form='form' type="text" name="username" required="required" />
            </div>
          </div>
          </div>
          <br>

          <div class="row">
            <div class='input-group'>
            <div class='col-3'>
            <div class='input-group-prepend'>
              <span class='input-group-text' id=''>Password</span>
            </div>
            </div>
            <div class='col-9 text-right'>
            <input class='form-control' form='form' type="password" name="password" required="required" />
            </div>
          </div>
          </div>
          <br>

          <div class="row">
            <div class='col-3'>
            <div class='input-group-prepend'>
            </div>
            </div>
            <div class='col-9 text-right'>
            <input class="btn btn-success form-contr" class='form-control' form='form' type="submit" value="Login"/>
            </div>
          </div>


          <br>
        </div>
        <div class="col-4">
        </div>
      </div>
    </div>
  </body>
</html>
