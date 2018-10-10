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

$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
$organization = mysqli_real_escape_string($conn, $_POST['organization']);
$url = mysqli_real_escape_string($conn, $_POST['url']);
$note = mysqli_real_escape_string($conn, $_POST['note']);

$phone = mysqli_real_escape_string($conn, $_POST['phone_0']);
$phone_tag = mysqli_real_escape_string($conn, $_POST['phone_tag_0']);
$email = mysqli_real_escape_string($conn, $_POST['email_0']);
$email_tag = mysqli_real_escape_string($conn, $_POST['email_tag_0']);
$address = mysqli_real_escape_string($conn, $_POST['address_0']);
$city = mysqli_real_escape_string($conn, $_POST['city_0']);
$state = mysqli_real_escape_string($conn, $_POST['state_0']);
$zipcode = mysqli_real_escape_string($conn, $_POST['zipcode_0']);
$address_tag = mysqli_real_escape_string($conn, $_POST['address_tag_0']);
echo "$phone";
//Add row to contacts table first
$sql = "INSERT INTO contacts (user_ID, first_name, middle_name, last_name, birth_date, organization, url, note)
VALUES ($user_ID, '$first_name', '$middle_name', '$last_name', IF('$birth_date' = '', NULL, '$birth_date'), '$organization', '$url', '$note')";
if ($conn->query($sql) === TRUE) {
    $contact_ID = mysqli_insert_id($conn);
    //Add to phones and addresses and addresses table
    $sql = "INSERT INTO phones (contact_ID, phone, tag)
    VALUES ($contact_ID, '$phone', '$phone_tag')";
    mysqli_query($conn, $sql);
    $sql = "INSERT INTO emails (contact_ID, email, tag)
    VALUES ($contact_ID, '$email', '$email_tag')";
    mysqli_query($conn, $sql);
    $sql = "INSERT INTO addresses (contact_ID, address, city, state, zipcode, tag)
    VALUES ($contact_ID, '$address', '$city', '$state', '$zipcode', '$address_tag')";
    mysqli_query($conn, $sql);
    Print '<script>alert("Contacts added successfully");</script>';
    header("location: modify.php?edit=$contact_ID");
} else {
    Print '<script>alert("Error on input, please check!");</script>';
    echo "Error, please check" . $conn->error . "<br>";
}
mysqli_close($conn);
?>
