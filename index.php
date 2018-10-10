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

  <body
  style="  background-image: url(/img/bg.png);
  background-position: right bottom;
  background-position: right bottom;
  background-size: 75%;
  background-repeat: no-repeat;">
    <?php  include 'navbar.php';
      echo "<br>";
    ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-3">
    </div>
    <div class="col-6 bg-light text-center" id="welcomebox">
      <h1>Han's Contacts Management System<h1><br>
      <a class="btn btn-dark" href="_initialization.php">Click to initilize DEMO database <a>
    </div>
    <div class="col-3">
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
