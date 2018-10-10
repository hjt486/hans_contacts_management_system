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

//Whether PHONE or EMAIL or ADDRESS
if (isset($_POST['phone']))
{
  $contact_ID = mysqli_real_escape_string($conn, $_POST['phone']);
  echo "$contact_ID";
  $sql = "INSERT INTO phones (contact_ID) VALUES ($contact_ID)";
  if ($conn->query($sql) === TRUE) {
      Print '<script>alert("Successful");</script>';
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
elseif (isset($_POST['email']))
{
  $contact_ID = mysqli_real_escape_string($conn, $_POST['email']);
  echo "$contact_ID";
  $sql = "INSERT INTO emails (contact_ID) VALUES ($contact_ID)";
  if ($conn->query($sql) === TRUE) {
      Print '<script>alert("Successful");</script>';
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
elseif (isset($_POST['address']))
{
  $contact_ID = mysqli_real_escape_string($conn, $_POST['address']);
  echo "$contact_ID";
  $sql = "INSERT INTO addresses (contact_ID) VALUES ($contact_ID)";
  if ($conn->query($sql) === TRUE) {
      Print '<script>alert("Successful");</script>';
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
else
mysqli_close($conn);
?>
