<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
$sql = "select * from users where username = '$user'";
$query = mysqli_query($conn, $sql);
$user_row = mysqli_fetch_assoc($query);
$user_ID = $user_row['ID'];
$user_first_name = $user_row['first_name'];
$user_last_name = $user_row['middle_name'];

//Whether NEW or EDIT or delete
if (isset($_GET['new']))
{
  $modify= mysqli_real_escape_string($conn, $_GET['new']);
  $first_name = ''; $middle_name = ''; $last_name = ''; $birth_date = ''; $organization = '';
  $url = ''; $note = '';
}
elseif (isset($_GET['edit']))
{
  $modify= mysqli_real_escape_string($conn, $_GET['edit']);

  $sql = "SELECT * FROM contacts where ID = '$modify'";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($query);
  $first_name = $row['first_name'];
  $middle_name = $row['middle_name'];
  $last_name = $row['last_name'];
  $birth_date = $row['birth_date'];
  $organization = $row['organization'];
  $url = $row['url'];
  $note = $row['note'];
}
else
{header("location: index.php");}
?>

<body>
  <?php include 'navbar.php'; ?><br>
  <div class="container-fluid">
    <div class="text-center">
      <h2 >
        <?php
        if (isset($_GET['new']))
        {
          echo "<h2 align='center'>New Contact</h2>";
          echo "<form action='modify_new.php' id='saveForm' method='POST'></form>";
        }
        elseif (isset($_GET['edit']))
        {
          echo "<h2 align='center'>{$first_name} {$last_name}</h2>";
          echo "
          <form method='GET' action='modify_delete.php' id='deleteForm'></form>
          <input type='hidden' name='contact_ID' value='$modify' form='deleteForm' /> <br/>";
          echo "
          <input class='btn btn-danger' type='submit' value='DELETE' form='deleteForm' onClick=\"return confirm('Are you sure you want to delete this contact?');\"/>";
          echo "<form action='modify_edit.php' id='saveForm' method='POST'></form>";
          echo "<input type='hidden' name='contact_ID' value='{$modify}' form='saveForm'/> <br>";
        }
        else{header("location: index.php");}
        ?>
      </h2>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col">
      </div>
      <div class="col-10 bg-light border rounded" id="box">
        <form>
          <div class='form-group'>
          <div class='container'>
          <?php echo"
              <br>

              <div class='row'>
                <div class='input-group'>
                <div class='col-1'>
                <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>Name:</span>
                </div>
                </div>
                  <div class='col-4'>
                    <input type='text' style='font-weight: bold;' class='form-control' name='first_name' placeholder='first' value='$first_name' form='saveForm' >
                  </div>
                  <div class='col-3' >
                    <input type='text' style='font-weight: bold;' class='form-control' name='middle_name' placeholder='middle' value='$middle_name' form='saveForm' >
                  </div>
                  <div class='col-4'>
                    <input type='text' style='font-weight: bold;' class='form-control' name='last_name' placeholder='last' value='$last_name' form='saveForm' >
                  </div>
                </div>
              </div>
              <br>

              <div class='row'>
                <div class='input-group'>
                <div class='col-2'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>Date of Birth:</span>
                  </div>
                </div>
                  <div class='col-3'>
                    <input type='text' class='form-control' name='birth_date' placeholder='date of birth' value='$birth_date' form='saveForm' >
                  </div>
                  <div class='col-2' >
                    <div class='input-group-prepend'>
                    <span class='input-group-text' id=''>Organization:</span>
                    </div>
                  </div>
                  <div class='col-5'>
                    <input type='text' class='form-control' name='organization' placeholder='organization' value='$organization' form='saveForm' >
                  </div>
                </div>
              </div>
              <br>


              <div class='row'>
                <div class='input-group'>
                <div class='col-1'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>URL:</span>
                  </div>
                </div>
                  <div class='col-11'>
                    <input type='text' class='form-control' name='url' placeholder='URL' value='$url' form='saveForm' >
                  </div>
                </div>
              </div>
              <br>


              <div class='row'>
                <div class='input-group'>
                <div class='col-1'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>Note:</span>
                  </div>
                </div>
                  <div class='col-11'>
                    <input type='text' class='form-control' name='note' placeholder='note' value='$note' form='saveForm' >
                  </div>
                </div>
              </div>
              <br>
              <hr>
              <br>

          "?>

          <?php
          // Show multiple PHONEs
          $sql = "SELECT * FROM phones where contact_ID = '$modify'";
          $query = mysqli_query($conn, $sql);
          while ($phone = mysqli_fetch_assoc($query))
          {
            $phones[] = $phone;
          }
          $i = 0;
          if (isset($phones))
          {
            foreach ($phones as $phone)
            {
              $i++;
              echo "
              <form id='delete_phone_Form_{$i}' action='modify_remove.php' method='POST'></form>
              <input type='hidden' name='phone' value='{$phone['ID']}' form='delete_phone_Form_{$i}'/>
              <input type='hidden' name='contact_ID' value='{$modify}' form='delete_phone_Form_{$i}' />
              <input type='hidden' name='phone_ID_{$i}' value='{$phone['ID']}' form='saveForm' />

              <div class='row'>
                <div class='input-group'>

                  <div class='col-3'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id=''>Phone Number # $i:</span>
                    </div>
                  </div>

                  <div class='col-3'>
                      <input type='text' class='form-control' name='phone_{$i}' placeholder='phone number' value='{$phone['phone']}' form='saveForm' >
                  </div>

                  <div class='col-3'>
                      <input type='text' class='form-control' name='phone_tag_{$i}' placeholder='phone number tag' value='{$phone['tag']}' form='saveForm' >
                  </div>

                  <div class='col-3 text-right'>
                      <input class='btn btn-warning' type='submit' value='Delete phone #$i' form='delete_phone_Form_{$i}' />
                </div>

              </div>

              </div>
              <br>

              ";
            }
          }
          else
          {
            echo "

            <div class='row'>
              <div class='input-group'>

                <div class='col-3'>
                  <div class='input-group-prepend'>
                    <span class='input-group-text' id=''>Phone Number:</span>
                  </div>
                </div>

                <div class='col-5'>
                    <input type='text' class='form-control' name='phone_{$i}' placeholder='phone number' value='{$phone['phone']}' form='saveForm' >
                </div>

                <div class='col-4'>
                    <input type='text' class='form-control' name='phone_tag_{$i}' placeholder='phone number tag' value='{$phone['tag']}' form='saveForm' >
                </div>


            </div>

            </div>
            <br>


            ";
          }

          if ($modify != 0)
          {
            echo "<form id='add_phone_Form' action='modify_add.php' method='POST'></form>";
            echo "<input type='hidden' name='phone' value='{$modify}' form='add_phone_Form'/>";
            echo "<input type='hidden' name='phone_count' value='{$i}' form='saveForm'/>";
            echo "
            <div class='row'>
              <div class='input-group'>
                <div class='col-4'>
                <hr>
                </div>
                <div class='col-4 text-center'>
                <input class='btn btn-success' type='submit' value='Add A Phone Number' form='add_phone_Form' />
                </div>
                <div class='col-4'>
                <hr>
                </div>

              </div>

            </div>
            <br>

            ";
          }
          ?>
          <?php
          // Show multiple EMAILs
          $sql = "SELECT * FROM emails where contact_ID = '$modify'";
          $query = mysqli_query($conn, $sql);
          while ($email = mysqli_fetch_assoc($query))
          {
            $emails[] = $email;
          }
          $j = 0;
          if (isset($emails))
          {
            foreach ($emails as $email)
            {
              $j++;
              echo "
              <form id='delete_email_Form_{$j}' action='modify_remove.php' method='POST'></form>
              <input type='hidden' name='email' value='{$email['ID']}' form='delete_email_Form_{$j}'/>
              <input type='hidden' name='contact_ID' value='{$modify}' form='delete_email_Form_{$j}' />
              <input type='hidden' name='email_ID_{$j}' value='{$email['ID']}' form='saveForm' />

              <div class='row'>
                <div class='input-group'>

                  <div class='col-2'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id=''>Email #$j:</span>
                    </div>
                  </div>

                  <div class='col-4'>
                      <input type='text' class='form-control' name='email_{$j}' placeholder='email' value='{$email['email']}' form='saveForm' >
                  </div>

                  <div class='col-3'>
                      <input type='text' class='form-control' name='email_tag_{$j}' placeholder='email tag' value='{$email['tag']}' form='saveForm' >
                  </div>

                  <div class='col-3 text-right'>
                      <input class='btn btn-warning' type='submit' value='Delete Email #$j' form='delete_email_Form_{$j}' />
                </div>

              </div>

              </div>
              <br>

              ";
            }
          }
          else
          {
            echo "

            <div class='row'>
              <div class='input-group'>

                <div class='col-2'>
                  <div class='input-group-prepend'>
                    <span class='input-group-text' id=''>Email:</span>
                  </div>
                </div>

                <div class='col-5'>
                    <input type='text' class='form-control' name='email_{$j}' placeholder='email' value='{$email['email']}' form='saveForm' >
                </div>

                <div class='col-4'>
                    <input type='text' class='form-control' name='email_tag_{$j}' placeholder='email tag' value='{$email['tag']}' form='saveForm' >
                </div>


            </div>

            </div>
            <br>

            ";
          }

          if ($modify != 0)
          {
            echo "<form id='add_email_Form' action='modify_add.php' method='POST'></form>";
            echo "<input type='hidden' name='email' value='{$modify}' form='add_email_Form'/>";
            echo "<input type='hidden' name='email_count' value='{$j}' form='saveForm'/>";
            echo "
            <div class='row'>
              <div class='input-group'>
                <div class='col-5'>
                <hr>
                </div>
                <div class='col-2 text-center'>
                <input class='btn btn-success' type='submit' value='Add An Email' form='add_email_Form' />
                </div>
                <div class='col-5'>
                <hr>
                </div>

            </div>

            </div>
            <br>

            ";
          }
          ?>

          <?php
          // Show multiple ADDRESSes
          $sql = "SELECT * FROM addresses where contact_ID = '$modify'";
          $query = mysqli_query($conn, $sql);
          while ($address = mysqli_fetch_assoc($query))
          {
            $addresses[] = $address;
          }
          $k = 0;
          if (isset($addresses))
          {
            foreach ($addresses as $address)
            {
              $k++;
              echo "
              <form id='delete_address_Form_{$k}' action='modify_remove.php' method='POST'></form>
              <input type='hidden' name='address' value='{$address['ID']}' form='delete_address_Form_{$k}'/>
              <input type='hidden' name='contact_ID' value='{$modify}' form='delete_address_Form_{$k}' />
              <input type='hidden' name='address_ID_{$k}' value='{$address['ID']}' form='saveForm' />

              <div class='row'>
                <div class='input-group'>

                  <div class='col-2'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id=''>Address # $k:</span>
                    </div>
                  </div>

                  <div class='col-10'>
                      <input type='text' class='form-control' name='address_{$k}' placeholder='address' value='{$address['address']}' form='saveForm' >
                  </div>

              </div>
              </div>
              <br>

              <div class='row'>
                <div class='input-group'>

                  <div class='col-2'>
                      <input type='text' class='form-control' name='city_{$k}' placeholder='city' value='{$address['city']}' form='saveForm' >
                  </div>
                  <div class='col-3'>
                      <input type='text' class='form-control' name='state_{$k}' placeholder='state' value='{$address['state']}' form='saveForm' >
                  </div>
                  <div class='col-2'>
                      <input type='text' class='form-control' name='zipcode_{$k}' placeholder='state' value='{$address['zipcode']}' form='saveForm' >
                  </div>
                  <div class='col-2'>
                      <input type='text' class='form-control' name='address_tag_{$k}' placeholder='tag' value='{$address['tag']}' form='saveForm' >
                  </div>
                  <div class='col-3 text-right'>
                      <input class='btn btn-warning' type='submit' value='Delete Address #$k' form='delete_address_Form_{$k}' />
                  </div>

              </div>
              </div>
              <br>

              ";
            }
          }
          else
          {
            echo "
            <div class='row'>
              <div class='input-group'>

                <div class='col-2'>
                  <div class='input-group-prepend'>
                    <span class='input-group-text' id=''>Address:</span>
                  </div>
                </div>

                <div class='col-10'>
                    <input type='text' class='form-control' name='address_{$k}' placeholder='address' value='{$address['address']}' form='saveForm' >
                </div>

            </div>
            </div>
            <br>

            <div class='row'>
              <div class='input-group'>

                <div class='col-2'>
                    <input type='text' class='form-control' name='city_{$k}' placeholder='city' value='{$address['city']}' form='saveForm' >
                </div>
                <div class='col-3'>
                    <input type='text' class='form-control' name='state_{$k}' placeholder='state' value='{$address['state']}' form='saveForm' >
                </div>
                <div class='col-2'>
                    <input type='text' class='form-control' name='zipcode_{$k}' placeholder='state' value='{$address['zipcode']}' form='saveForm' >
                </div>
                <div class='col-2'>
                    <input type='text' class='form-control' name='address_tag_{$k}' placeholder='tag' value='{$address['tag']}' form='saveForm' >
                </div>
                <div class='col-3 text-right'>
                </div>

            </div>
            </div>
            <br>

            ";
          }
          if ($modify != 0)
          {

            echo "<form id='add_address_Form' action='modify_add.php' method='POST'></form>";
            echo "<input type='hidden' name='address' value='{$modify}' form='add_address_Form'/>";
            echo "<input type='hidden' name='address_count' value='{$k}' form='saveForm'/>";
            echo "
            <div class='row'>
              <div class='input-group'>
                <div class='col-5'>
                <hr>
                </div>
                <div class='col-2 text-center'>
                <input class='btn btn-success' type='submit' value='Add An Address' form='add_address_Form' />
                </div>
                <div class='col-5'>
                <hr>
                </div>

            </div>

            </div>
            <br>

            ";

          }
          echo "
          <br><br>
          <div class='row'>
            <div class='input-group'>
              <div class='col-4'>
              <hr>
              </div>
              <div class='col-2 text-center'>
              <input class='btn btn-primary' type='submit' value='Submit' form='saveForm' />
              </div>
              <div class='col-2 text-center'>
              <a class='btn btn-secondary' href='home.php' onClick=\"return confirm('Are you sure to return to contacts list?\\nAll changes will be lost');\">Return</a>
              </div>
              <div class='col-4'>
              <hr>
              </div>

          </div>

          </div>"
          ?>



        </div>
        </div>
        </form>
      </div>
      <div class="col">
      </div>
  </div>
  </div>
<?php include 'footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>

<?php
  mysqli_close($conn);
?>
