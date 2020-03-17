<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>

<html>
<head>
    <title> Transparent Login Form Design </title>
    <link rel="stylesheet" type="text/css" href="dist/css/login_V2.css">
</head>
<body>
<div class="login-box">
    <h1>Connexion</h1>
    <form action="includes/authenticate.php" method="post">
        <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
        <div class="textbox">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
        </div>

        <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
        </div>

        <input type="submit" class="btn" value="s'identifier">
    </form>
</div>

</body>
</html>