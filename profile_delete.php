<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

<?php
// Login check
session_start();
if($_SESSION['user']){}
else{header("location: index.php");}
$user = $_SESSION['user'];

// Establish database connection
require '_dbsetup.php';
$conn = new mysqli($servername, $server_username, $server_password, $dbname);

// Get user_ID
$user_ID= mysqli_real_escape_string($conn, $_GET['user_ID']);
$sql = "DELETE FROM users where ID = '$user_ID'";
?>

<body>
  <div class="container-fluid">
    <div class="text-center">
        <?php
        if ($conn->query($sql) === TRUE) {
            echo "
            <div class='row'>
              <div class='col-3'>
              </div>
              <div class='col-6' text-center>
                <h2>Account closed!</h2>
              </div>

              <div class='col-3'>
              </div>
            </div>

            <div class='row'>
            <div class='col-3'>
            </div>
            <div class='col-6' text-center>
              <a class='btn btn-light' href='logout.php'>Click to Continue<a>
            </div>
            <div class='col-3'>
            </div>
            </div>

            ";
        } else {
            Print '<script>alert("Error, please check!");</script>';
            echo "Error, please check" . $conn->error . "<br>";
        }
        mysqli_close($conn);
        ?>
    </div>
  </div>
</body>
