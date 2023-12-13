<?php
session_start();
require('api.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    require('./starter-scripts/bootstrap.html');
    require('./starter-scripts/jquery.html');
    require('./starter-scripts/fancybox.html');
    require('./starter-scripts/mapbox.html');
    ?>


    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="./styles/form_style.css">
    <link rel="stylesheet" href="./styles/header.css">

    <script src="script.js"></script>

    <title>Administrador</title>

</head>

<body>
    <!-- Sidebar-->
    <?php require('sidebar.php'); ?>
    <!-- Header-->
    <?php require('header.php'); ?>
    <!--     <?= '<pre>' . var_dump($_SESSION["user"]) . '</pre>' ?>
    <?= '<pre>' . var_dump($_SESSION["usern"]) . '</pre>' ?>
    <?= '<pre>' . var_dump($_SESSION["passw"]) . '</pre>' ?>
    <?= '<pre>' . var_dump($_SESSION["userpass"]) . '</pre>' ?> -->

    <!-- Page content-->
    <section style="margin-top: 100px">
        <form class="form" method="POST">
            <p class="form-title">Log in</p>

            <?php inputField("Utilizador", "username", "text", "", "username", "", ""); ?>
            <?php inputField("Password", "password", "password", "", "password", "", ""); ?>

            <button type="submit" class="submit">
                Log in
            </button>
            <div>
                <input name="action" value="login" hidden>
            </div>
        </form>
    </section>
</body>

</html>

<?php

printToast('toastUserSignInError');

?>