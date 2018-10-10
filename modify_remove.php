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
  $phone_ID = mysqli_real_escape_string($conn, $_POST['phone']);
  echo $_POST['contact_ID'];
  $contact_ID = mysqli_real_escape_string($conn, $_POST['contact_ID']);
  echo "$contact_ID";
  $sql = "DELETE FROM phones where ID = '$phone_ID'";
  if ($conn->query($sql) === TRUE) {
      echo "Successfully";
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Deleted error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
elseif (isset($_POST['email']))
{
  $email_ID = mysqli_real_escape_string($conn, $_POST['email']);
  $contact_ID = mysqli_real_escape_string($conn, $_POST['contact_ID']);
  echo "$contact_ID";
  $sql = "DELETE FROM emails where ID = '$email_ID'";
  if ($conn->query($sql) === TRUE) {
      echo "Successfully";
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Deleted error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
elseif (isset($_POST['address']))
{
  $address_ID = mysqli_real_escape_string($conn, $_POST['address']);
  $contact_ID = mysqli_real_escape_string($conn, $_POST['contact_ID']);
  echo "$contact_ID";
  $sql = "DELETE FROM addresses where ID = '$address_ID'";
  if ($conn->query($sql) === TRUE) {
      echo "Successfully";
      header("location: modify.php?edit=$contact_ID");
  } else {
      Print '<script>alert("Deleted error, please check!");</script>';
      echo "Error, please check" . $conn->error . "<br>";
  }
}
mysqli_close($conn);
?>
