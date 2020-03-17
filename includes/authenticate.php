<?php

session_start();
include 'conn.php';

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    die ('Please fill both the username and password field!');
}


$username = $conn->real_escape_string($_POST['username']);
$password = md5($_POST['password']); //md5 hash password security
//Query the database for user
$sql = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'") or die($conn->error);

if ($sql->num_rows > 0) {

    // Verification success! User has loggedin!
    // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
    $sql = $conn->query("SELECT admin as 'ad', id as 'id' FROM users WHERE username = '$username'") or die($conn->error);
    $obj = $sql->fetch_object();
    $id = $obj->id;
    $admin = $obj->ad;
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $_POST['username'];
    $_SESSION['id'] = $id;
    $_SESSION['admin'] = $admin;
    $_SESSION['create'] = 0;
    $_SESSION['update'] = 0;
    $_SESSION['delete'] = 0;

    $conn->close();

    header('Location: ../home.php');
} else {
    $_SESSION['message'] = 'Username / Password is incorrect!';

    $conn->close();
    header("location: ../errorlogin.php");
}
?>