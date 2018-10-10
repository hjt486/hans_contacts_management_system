<?php
require '_dbsetup.php';
?>

<html>
  <head>
    <title>Han's Contacts Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-3">
      </div>
      <div class="col-6 bg-light text-center" id="welcomebox">
        <h2>Welcome to Han's Contacts Management System<h2><br>
        <h4>Please follow the Instruction below:</h4><br>
        <div>
        <p>1. Please change database setting in "_dbsetup.php" first</p><br>
        <p>2. Refresh the page to continue initialization</p><br>
        <p>3. After initialization, login with username "hjt486" password "0000"</p><br>
        <p>4. Other available users' information can be found in "_dbint/users.sql"</p><br>

        <h4>Initialization begins:</h4><br>
        <?php
        // Create connection
        $conn = new mysqli($servername, $server_username, $server_password);
        // Check connection
        if ($conn->connect_error) {
            die("MySQL connected failed: " . $conn->connect_error . "<br>");
        }
        echo "MySQL connected successfully<br>";

        $sql = "DROP DATABASE $dbname";
        if ($conn->query($sql) === TRUE) {
            echo "Database dropped successfully<br>";
        }

        // Create database
        $sql = "CREATE DATABASE $dbname";
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully<br>";
        } else {
            echo "Error creating database: " . $conn->error . "<br>";
        }

        // Connect to database
        mysqli_select_db($conn, "$dbname");
        // Check connection
        if ($conn->connect_error) {
            die("Database connected failed: " . $conn->connect_error . "<br>");
        }
        echo "Database connected successfully<br>";

        $sql = "CREATE TABLE users (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL,
        first_name VARCHAR(50),
        middle_name VARCHAR(50),
        last_name VARCHAR(50),
        phone VARCHAR(10),
        email VARCHAR(50),
        UNIQUE (username)
        )";
        // Check table creation
        if ($conn->query($sql) === TRUE) {
            echo "Table 'users' created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }

        $sql = "CREATE TABLE contacts (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_ID INT(6) UNSIGNED NOT NULL,
        first_name VARCHAR(50),
        middle_name VARCHAR(50),
        last_name VARCHAR(50),
        birth_date DATE,
        organization VARCHAR(50),
        url text,
        note text,
        FOREIGN KEY (user_ID) REFERENCES users(ID) ON DELETE CASCADE
        )";
        // Check table creation
        if ($conn->query($sql) === TRUE) {
            echo "Table 'contacts' created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }

        $sql = "CREATE TABLE phones (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        contact_ID INT(6) UNSIGNED NOT NULL,
        phone VARCHAR(10),
        tag VARCHAR(50),
        FOREIGN KEY (contact_ID) REFERENCES contacts(ID) ON DELETE CASCADE
        )";
        // Check table creation
        if ($conn->query($sql) === TRUE) {
            echo "Table 'phones' created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }

        $sql = "CREATE TABLE emails (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        contact_ID INT(6) UNSIGNED NOT NULL,
        email VARCHAR(50),
        tag VARCHAR(50),
        FOREIGN KEY (contact_ID) REFERENCES contacts(ID) ON DELETE CASCADE
        )";
        // Check table creation
        if ($conn->query($sql) === TRUE) {
            echo "Table 'emails' created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }

        $sql = "CREATE TABLE addresses (
        ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        contact_ID INT(6) UNSIGNED NOT NULL,
        address VARCHAR(100),
        city VARCHAR(50),
        state VARCHAR(50),
        zipcode VARCHAR(50),
        tag VARCHAR(50),
        FOREIGN KEY (contact_ID) REFERENCES contacts(ID) ON DELETE CASCADE
        )";
        // Check table creation
        if ($conn->query($sql) === TRUE) {
            echo "Table 'addresses' created successfully<br>";
        } else {
            echo "Error creating table: " . $conn->error . "<br>";
        }

        // Input data to tables
        $addresses_data = file_get_contents('./_dbint/addresses.sql');
        $contacts_data = file_get_contents('./_dbint/contacts.sql');
        $emails_data = file_get_contents('./_dbint/emails.sql');
        $phones_data = file_get_contents('./_dbint/phones.sql');
        $users_data = file_get_contents('./_dbint/users.sql');

        if ($conn->multi_query($users_data) == true) {
          echo "Data 'users' input successfully" . $conn->error . "<br>";
        } else {
          echo "Data 'users' input error<br>";
        }
        $conn = new mysqli($servername, $server_username, $server_password, $dbname);

        if ($conn->multi_query($contacts_data) == true) {
          echo "Data 'contacts' input successfully" . $conn->error . "<br>";
        } else {
          echo "Data 'contacts' input error<br>";
        }
        while(mysqli_next_result($conn)){;}

        if ($conn->multi_query($addresses_data) == true) {
          echo "Data 'addresses' input successfully" . $conn->error . "<br>";
        } else {
          echo "Data 'addresses' input error<br>";
        }
        while(mysqli_next_result($conn)){;}

        if ($conn->multi_query($emails_data) == true) {
          echo "Data 'emails' input successfully" . $conn->error . "<br>";
        } else {
          echo "Data 'emails' input error<br>";
        }
        while(mysqli_next_result($conn)){;}

        if ($conn->multi_query($phones_data) == true) {
          echo "Data 'phones' input successfully" . $conn->error . "<br>";
        } else {
          echo "Data 'phones' input error<br>";
        }
        while(mysqli_next_result($conn)){;}

        $conn->close();
        ?>
        <br>
        <a class="btn btn-dark" href="login.php">Click to login<a>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        </body>
      </div>
      <div class="col-3">
      </div>
    </div>
  </div>
