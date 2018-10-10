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
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
?>

<body>
<div class="container-fluid">
  <div class="text-center">
  <?php
  $bool = true;
  $sql = "select * from users";
  $query = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_array($query))
  {
    $table_users = $row['username'];
    if($username == $table_users)
    {
      $bool = false;
    }
  }
  if ($bool == ture){
  if ($password == $password2) {
    $sql = "INSERT INTO users (username, password, first_name, middle_name, last_name, phone, email)
    VALUES ('$username', '$password', '$first_name', '$middle_name', '$last_name', '$phone', '$email')";
    if ($conn->query($sql) === TRUE) {
      echo "
      <div class='row'>
        <div class='col-3'>
        </div>
        <div class='col-6' text-center>
          <h2>Account Created</h2>
        </div>

        <div class='col-3'>
        </div>
      </div>

      <div class='row'>
      <div class='col-3'>
      </div>
      <div class='col-6' text-center>
        <a class='btn btn-light' href='login.php'>Click to login<a>
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
      <a class='btn btn-light' href='profile.php'>Click to try again<a>
    </div>
    <div class='col-3'>
    </div>
    </div>";
  }
}
else {
  echo "
  <div class='row'>
    <div class='col-3'>
    </div>
    <div class='col-6' text-center>
      <h2>Username already exists! Please use a differnt one</h2>
    </div>

    <div class='col-3'>
    </div>
  </div>

  <div class='row'>
  <div class='col-3'>
  </div>
  <div class='col-6' text-center>
    <a class='btn btn-light' href='profile.php'>Click to try again<a>
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
