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

// Establish database connection
require '_dbsetup.php';
$conn = new mysqli($servername, $server_username, $server_password, $dbname);

// Get user_ID

//Whether NEW or EDIT or delete
if (isset($_GET['edit']))
{
  $sql = "select * from users where username = '$user'";
  $query = mysqli_query($conn, $sql);
  $user_row = mysqli_fetch_assoc($query);
  $user_ID = $user_row['ID'];
  $username = $user_row['username'];
  $first_name = $user_row['first_name'];
  $middle_name = $user_row['middle_name'];
  $last_name = $user_row['last_name'];
  $phone = $user_row['phone'];
  $email = $user_row['email'];
  $user_first_name = $user_row['first_name'];
  $user_last_name = $user_row['middle_name'];
}
else
{
  $username = ''; $password = ''; $password2 = '';
  $first_name = ''; $middle_name = ''; $last_name = ''; $phone = ''; $email = '';
}
?>

<body>
  <?php  include 'navbar.php';
    echo "<br>";
  ?>
  <div class="container-fluid">
    <div class="text-center">
      <h2 >
        <?php
        if (isset($_GET['edit']))
        {
          echo "<h2 align='center'>{$first_name} {$last_name}</h2>";
          echo "
          <form method='GET' action='profile_delete.php' id='deleteForm'></form>
          <input type='hidden' name='user_ID' value='$user_ID' form='deleteForm' /> <br/>";
          echo "
          <input class=\"btn btn-danger\" type=\"submit\" value=\"DELETE ACCOUNT\" form=\"deleteForm\" onClick=\"return confirm('Are you sure to delete this account?\\nAll your contacts will be lost!');\"/>";
          echo "<form action='profile_edit.php' id='saveForm' method='POST'></form>";
          echo "<input type='hidden' name='user_ID' value='{$user_ID}' form='saveForm'/> <br>";
        }
        else
        {
          echo "<h2 align='center'>New User</h2>";
          echo "<form action='profile_new.php' id='saveForm' method='POST'></form>";
        }
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
            <div class='col-2'>
            <div class='input-group-prepend'>
              <span class='input-group-text' id=''>Username:</span>
            </div>";
            if($_SESSION)
            { echo "
            </div>
              <div class='col-10'>
                <input class='form-control' style='font-weight: bold;' id='disabledInput' type='text' placeholder='{$username}' disabled>
              </div>
            </div>
          </div>
        ";}
        else{echo "
        </div>
          <div class='col-10'>
          <input type='text' style='font-weight: bold;' class='form-control' name='username' placeholder='username' value='$username' form='saveForm' >
          </div>
        </div>
      </div>
    ";}
    echo "
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
              <span class='input-group-text' id=''>Password:</span>
              </div>
            </div>
              <div class='col-3'>
                <input type='password' class='form-control' name='password' placeholder='password' form='saveForm' >
              </div>
              <div class='col-3' >
                <div class='input-group-prepend'>
                <span class='input-group-text' id=''>Re-enter password:</span>
                </div>
              </div>
              <div class='col-4'>
                <input type='password' class='form-control' name='password2' placeholder='re-enter password to verify' form='saveForm' >
              </div>
            </div>
          </div>
          <br>


          <div class='row'>
            <div class='input-group'>

              <div class='col-2'>
                <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>Phone Number:</span>
                </div>
              </div>

              <div class='col-3'>
                  <input type='text' class='form-control' name='phone' placeholder='phone number' value='$phone' form='saveForm' >
              </div>

              <div class='col-1'>
                <div class='input-group-prepend'>
                  <span class='input-group-text' id=''>Email:</span>
                </div>
              </div>

              <div class='col-6 text-right'>
                  <input type='text' class='form-control' name='email' placeholder='email' value='$email' form='saveForm' >
            </div>

          </div>

          </div>

          "?>

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

          </div>

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
