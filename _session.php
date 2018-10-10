<?php
	require '_dbsetup.php';
	$conn = new mysqli($servername, $server_username, $server_password, $dbname);

	session_start();
	$username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
	$sql = "SELECT * from users WHERE username='$username'";
	$query = mysqli_query($conn, $sql);
	$exists = mysqli_num_rows($query);
	$match_users = "";
	$match_password = "";

	if($exists > 0)
	{
		while($row = mysqli_fetch_array($query)) //display all rows from query
		{
			$match_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
			$match_password = $row['password']; // the first password row is passed on to $table_users, and so on until the query is finished
		}
		if(($username == $match_users) && ($password == $match_password)) // checks if there are any matching fields
		{
				if($password == $match_password)
				{
					$_SESSION['user'] = $username; //set the username in a session. This serves as a global variable
					header("location: home.php"); // redirects the user to the authenticated home page
				}

		}
		else
		{
			Print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
			Print '<script>window.location.assign("login.php");</script>'; // redirects to login.php
		}
	}
	else
	{
		Print '<script>alert("Incorrect Username!");</script>'; //Prompts the user
		Print '<script>window.location.assign("login.php");</script>'; // redirects to login.php
	}
?>
