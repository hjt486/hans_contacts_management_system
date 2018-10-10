<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

<?php
// Login checkbox
session_start();
if($_SESSION['user']){}
else{header("location: index.php");}
$user = $_SESSION['user'];

// Establish database connection
require '_dbsetup.php';
$conn = new mysqli($servername, $server_username, $server_password, $dbname);

// Query for all contacts belong to the user
$sql = "select * from users where username = '$user'";
$query = mysqli_query($conn, $sql);
$user_row = mysqli_fetch_assoc($query);
$user_ID = $user_row['ID'];
$user_first_name = $user_row['first_name'];
$user_last_name = $user_row['middle_name'];
echo "<form id='orderFirstNameForm' method='GET'></form>";
echo "<input type='hidden' name='order' value='first_name' form='orderFirstNameForm' />";
echo "<form id='orderOrganizationForm' method='GET'></form>";
echo "<input type='hidden' name='order' value='organization' form='orderOrganizationForm' />";
?>


<body>
  <?php include 'navbar.php'; ?>
  <br>
  <div class="container-fluid">
    <div class="text-center">
      <h2 ><?php
      echo $user_row['first_name'];
      echo " ".$user_row['last_name'];
      ?>'s Contacts</h2>
    </div>

    <div class="text-center">
      <form action="modify.php" method="GET">
        <input type="hidden" name="new" value="0" /> <br/>
        <input class="btn btn-success" type="submit" value="Add a Contact"/>
      </form>
    </div>

    <div class="text-center">
      <table class='table table-sm table-striped'>
      <thead class="thead-dark" >
        <tr>
          <th scope="col">
            <a href='#' style='color: white;' onclick='orderFirstNameForm.submit();'>First Name</a>
          </th>
          <th scope="col">
            <a href='home.php' style='color: white;'>Last Name</a>
          </th>
          <th scope="col">
            <a href='#' style='color: white;' onclick='orderOrganizationForm.submit();'>Organization</a>
          </th>
          <th scope="col" style='color: grey;'>Note</th>
          <th scope="col" style='color: grey;'>Edit</th></tr>
      </thead>
      <tbody>
      <?php
        if(isset($_GET['order']))
        {
          $orderby = $_GET['order'];
          $sql = "select * from contacts where user_ID = '$user_ID' order by $orderby";
          $query = mysqli_query($conn, $sql);
          $i=0;
          while ($row = mysqli_fetch_assoc($query))
           {
             echo "<form action='modify.php' id='edit_Form_{$i}' method='GET'> </form>
             <input type='hidden' name='edit' value='{$row['ID']}' form='edit_Form_{$i}'/>
             <tr scope='row'>
             <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$row['first_name']}</a></td>
             <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$row['last_name']}</a></td>
             <td>{$row['organization']}</td>
             <td>{$row['note']}</td>
             <td class='text-center'>
             <input class='btn btn-warning btn-sm' type='submit' value='Edit' form='edit_Form_{$i}' />
             </td>
             </tr>";
             $i++;
           }
        }
        elseif(isset($_GET['search']))
        {
          $search = $_GET['search'];
          $sql = "
          select distinct contact_ID from
          (select
              a.`email` as email,
              a.`tag` as email_tag,
              a.`contact_ID` as contact_ID3,
              b.*
          from emails a
          right join
          (select
              a.`phone` as phone,
              a.`tag` as phone_tag,
              a.`contact_ID` as contact_ID2,
              b.*
          from phones a
          right join
          (select
          	a.`ID` as contact_ID,
              a.`user_ID`as user_ID,
              a.`first_name` as first_name,
              a.`middle_name` as middle_name,
              a.`last_name`as last_name,
              a.`birth_date` as birth_date,
              a.`organization`as organization,
              a.`url` as url,
              a.`note` as note,
              b.`contact_ID` as contact_ID1,
              b.`address` as address,
              b.`city` as city,
              b.`state` as state,
              b.`zipcode` as zipcode,
              b.`tag` as address_tag
          from contacts a
          left join addresses b
          on a.ID = b.contact_ID
          where user_ID = '$user_ID') b
          on a.contact_ID = b.contact_ID) b
          on a.contact_ID = b.contact_ID) c
          where  concat_ws(first_name, middle_name, last_name, birth_date, organization, url, note,
          address, city, state, zipcode, address_tag,
          phone, phone_tag, email, email_tag) like '%$search%'
          ";
          $query = mysqli_query($conn, $sql);
          $i=0;
          while ($row = mysqli_fetch_assoc($query))
           {
             $sql2 = "select * from contacts where ID = {$row['contact_ID']}";
             $query2 = mysqli_query($conn, $sql2);
             $contact_selected = mysqli_fetch_assoc($query2);
             echo "<form action='modify.php' id='edit_Form_{$i}' method='GET'> </form>
             <input type='hidden' name='edit' value='{$contact_selected['ID']}' form='edit_Form_{$i}'/>
             <tr scope='row'>
             <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$contact_selected ['first_name']}</a></td>
             <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$contact_selected ['last_name']}</a></td>
             <td>{$contact_selected['organization']}</td>
             <td>{$contact_selected['note']}</td>
             <td class='text-center'>
             <input class='btn btn-warning btn-sm' type='submit' value='Edit' form='edit_Form_{$i}' />
             </td>
             </tr>";
             $i++;
           }
        }
        else{
        $i=0;
        $sql = "select * from contacts where user_ID = '$user_ID' order by last_name";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($query))
         {
           echo "<form action='modify.php' id='edit_Form_{$i}' method='GET'> </form>
           <input type='hidden' name='edit' value='{$row['ID']}' form='edit_Form_{$i}'/>
           <tr scope='row'>
           <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$row['first_name']}</a></td>
           <td><a href='#' onclick='edit_Form_{$i}.submit();''>{$row['last_name']}</a></td>
           <td>{$row['organization']}</td>
           <td>{$row['note']}</td>
           <td class='text-center'>
           <input class='btn btn-warning btn-sm' type='submit' value='Edit' form='edit_Form_{$i}' />
           </td>
           </tr>";
            $i++;
          }
         }
        ?>
      </tbody>
    </table>
    </div>
  </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
