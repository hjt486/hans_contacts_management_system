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

//Get counts and contact_ID
$contact_ID = mysqli_real_escape_string($conn, $_POST['contact_ID']);
$phone_count = mysqli_real_escape_string($conn, $_POST['phone_count']);
$email_count = mysqli_real_escape_string($conn, $_POST['email_count']);
$address_count = mysqli_real_escape_string($conn, $_POST['address_count']);

$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
$organization = mysqli_real_escape_string($conn, $_POST['organization']);
$url = mysqli_real_escape_string($conn, $_POST['url']);
$note = mysqli_real_escape_string($conn, $_POST['note']);

// Update contact
$sql = "UPDATE contacts SET
first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name',
birth_date = IF('$birth_date' = '', NULL, '$birth_date'), organization = '$organization',
url = '$url', note = '$note' where ID = $contact_ID";
mysqli_query($conn, $sql);

// Update phones
if ($phone_count != 0)
{
  for ($i=1; $i<=$phone_count; $i++)
  {
    $phone_ID = mysqli_real_escape_string($conn, $_POST['phone_ID_'.$i]);
    $phone = mysqli_real_escape_string($conn, $_POST['phone_'.$i]);
    $phone_tag = mysqli_real_escape_string($conn, $_POST['phone_tag_'.$i]);

    echo $phone_ID;
    echo $phone;
    $sql = "UPDATE phones SET
    phone = '$phone', tag = '$phone_tag' where ID = $phone_ID";
    mysqli_query($conn, $sql);
  }
}
elseif ($phone_count == 0)
{
  $phone = mysqli_real_escape_string($conn, $_POST['phone_0']);
  $phone_tag = mysqli_real_escape_string($conn, $_POST['phone_tag_0']);
  $sql = "INSERT INTO phones (contact_ID, phone, tag)
  VALUES ($contact_ID, '$phone', '$phone_tag')";
  mysqli_query($conn, $sql);
}

if ($email_count != 0)
{
  for ($i=1; $i<=$email_count; $i++)
  {
    $email_ID = mysqli_real_escape_string($conn, $_POST['email_ID_'.$i]);
    $email = mysqli_real_escape_string($conn, $_POST['email_'.$i]);
    $email_tag = mysqli_real_escape_string($conn, $_POST['email_tag_'.$i]);
    $sql = "UPDATE emails SET
    email = '$email', tag = '$email_tag' where ID = $email_ID";
    mysqli_query($conn, $sql);
  }
}
elseif ($email_count == 0)
{
  $email = mysqli_real_escape_string($conn, $_POST['email_0']);
  $email_tag = mysqli_real_escape_string($conn, $_POST['email_tag_0']);
  $sql = "INSERT INTO emails (contact_ID, email, tag)
  VALUES ($contact_ID, '$email', '$email_tag')";
  mysqli_query($conn, $sql);
}

if ($address_count != 0)
{
  for ($i=1; $i<=$address_count; $i++)
  {
    $address_ID = mysqli_real_escape_string($conn, $_POST['address_ID_'.$i]);
    $address = mysqli_real_escape_string($conn, $_POST['address_'.$i]);
    $city = mysqli_real_escape_string($conn, $_POST['city_'.$i]);
    $state = mysqli_real_escape_string($conn, $_POST['state_'.$i]);
    $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode_'.$i]);
    $address_tag = mysqli_real_escape_string($conn, $_POST['address_tag_'.$i]);
    $sql = "UPDATE addresses SET
    address = '$address', city = '$city', state = '$state', zipcode = '$zipcode', tag = '$address_tag'
    where ID = $address_ID";
    mysqli_query($conn, $sql);
  }
}
elseif ($email_count == 0)
{
  $city = mysqli_real_escape_string($conn, $_POST['city_0']);
  $state = mysqli_real_escape_string($conn, $_POST['state_0']);
  $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode_0']);
  $address_tag = mysqli_real_escape_string($conn, $_POST['address_tag_0']);
  $sql = "INSERT INTO addresses (contact_ID, address, city, state, zipcode, tag)
  VALUES ($contact_ID, '$address', '$city', '$state', '$zipcode', '$address_tag')";
  mysqli_query($conn, $sql);
}
  header("location: modify.php?edit=$contact_ID");
  mysqli_close($conn);
?>
