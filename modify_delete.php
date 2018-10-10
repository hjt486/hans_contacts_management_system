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
$sql = "select ID from users where username = '$user'";
$query = mysqli_query($conn, $sql);
$user_row = mysqli_fetch_assoc($query);
$user_ID = $user_row['ID'];

$contact_ID= mysqli_real_escape_string($conn, $_GET['contact_ID']);

$sql = "SELECT * FROM contacts where ID = '$contact_ID'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
$contact_ID= $row['ID'];

  $sql = "DELETE FROM contacts where ID = '$contact_ID'";
  if ($conn->query($sql) === TRUE) {
      header("location: home.php");
  } else {
      Print '<script>alert("Contacts deleted error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
  mysqli_close($conn);
?>
