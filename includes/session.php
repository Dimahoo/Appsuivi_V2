<?php

session_start();
include 'includes/conn.php';


//Query the database for user
$sql = $conn->query("SELECT count(*) as 'c' FROM users") or die($mysqli->error);
$count = $sql->fetch_object()->c;

// check table is empty
if ($count > 0) {
    // Redirect to the create form page:
    header('Location: login.php');
}
else {
    // Redirect to the login form page
    header('Location: logincreateadmin.php');
}

$conn->close();

?>