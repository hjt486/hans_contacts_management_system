<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

<?php
// Login check
// Establish database connection
require '_dbsetup.php';
$conn = new mysqli($servername, $server_username, $server_password, $dbname);

// Get user_ID
$password = mysqli_real_escape_string($conn, $_POST['password']);
$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$user_ID = mysqli_real_escape_string($conn, $_POST['user_ID']);
?>

<body>
<div class="container-fluid">
  <div class="text-center">
  <?php
  if ($password == $password2) {
    $sql = "UPDATE users SET password = '$password',
    first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name',
    phone = '$phone', email = '$email'
    WHERE ID = $user_ID";
    if ($conn->query($sql) === TRUE) {
      echo "
      <div class='row'>
        <div class='col-3'>
        </div>
        <div class='col-6' text-center>
          <h2>Account Information Saved</h2>
        </div>

        <div class='col-3'>
        </div>
      </div>

      <div class='row'>
      <div class='col-3'>
      </div>
      <div class='col-6' text-center>
        <a class='btn btn-light' href='home.php'>Click to return<a>
      </div>
      <div class='col-3'>
      </div>
      </div>";
    }
    else {
        Print '<script>alert("Error, please check!");</script>';
        echo "Error, please check" . $conn->error . "<br>";}
      }
  else {
    echo "
    <div class='row'>
      <div class='col-3'>
      </div>
      <div class='col-6' text-center>
        <h2>Password didn't match!</h2>
      </div>

      <div class='col-3'>
      </div>
    </div>

    <div class='row'>
    <div class='col-3'>
    </div>
    <div class='col-6' text-center>
      <a class='btn btn-light' href='profile.php?edit'>Click to try again<a>
    </div>
    <div class='col-3'>
    </div>
    </div>";
  }
  mysqli_close($conn);
  ?>

  </div>
  </div>
</body>
