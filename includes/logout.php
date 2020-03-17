<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: /appsuivi_V2/index.php');
?>