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
    <script src="script.js"></script>

    <title>Administrador</title>

</head>

<body>

    <!-- Header-->
    <?php require('header.php'); ?>
    <!-- Page content-->
    <div>
        <section style="margin-top: 100px">

            <form class="form" method="POST">
                <p class="form-title">Regista um Administrador</p>
                <div class="input-container">
                    <input type="text" name="name" id="name" placeholder="Enter your name" autocomplete="new-name">
                </div>
                <div class="input-container">
                    <input type="text" name="username" id="username" placeholder="Enter your username" autocomplete="new-username">
                </div>
                <div class="input-container">
                    <input type="password" name="password" id="password" placeholder="Enter password" autocomplete="new-password">
                </div>
                <div>
                    <input name="action" value="register" hidden>
                </div>
                <button type="submit" class="submit">
                    Register
                </button>
            </form>
        </section>
    </div>
    </div>

    <?php
    echo $_SESSION['toast'];
    $_SESSION['toast'] = '';

    ?>

</body>

</html>