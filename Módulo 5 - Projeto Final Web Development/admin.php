<?php
session_start();
require('api.php');
if ($_SESSION["user"]) {
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

        <!-- 
    <?= '<pre> nome' . var_dump($_SESSION["name"]) . '</pre>' ?>
    <?= '<pre> nome' . var_dump($_SESSION["productType"]) . '</pre>' ?>
    <?= '<pre> quantidade ' . var_dump($_SESSION["quantity"]) . '</pre>' ?>
    <?= '<pre> preço ' . var_dump($_SESSION["ppu"]) . '</pre>' ?>
    <?= '<pre> imagem' . var_dump($_SESSION["image"]) . '</pre>' ?> 
    <?= '<pre>' . var_dump($_SESSION["user"]) . '</pre>' ?>

-->


        <script>
            $(document).ready(function () {
                <?php
                $getProductTypes();
                ?>
                /* Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Your work has been saved',
                  showConfirmButton: false,
                  timer: 1500
                }) */
            });
        </script>

        <!-- Sidebar-->
        <?php include('sidebar.php'); ?>
        <!-- Page content-->
        <div id="page-content-wrapper">
            <!-- Header-->
            <?php include('header.php'); ?>
            <!-- Page content-->
            <div>
                <div class="row d-flex justify-content-evenly">
                    <div class="mt-5 col-sm-3 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Encomendas dos clientes</h5>
                                <p class="card-text">Visualizar todas as encomendas dos clientes.</p>
                                <a href="orders.php" class="button submit" style="text-decoration: none;">Encomendas</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Adicionar e alterar artigos</h5>
                                <p class="card-text">Adicionar ou alterar todos os artigos da loja.</p>
                                <a href="products.php" class="button submit" style="text-decoration: none;">Artigos</a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Utilizadores admin</h5>
                                <p class="card-text">Adicionar ou alterar os administradores da loja.</p>
                                <a href="users.php" class="button submit" style="text-decoration: none;">Utilizadores</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>

        <?php

        printToast('toastUserSignedIn');
} else {
    header('Location: ' . 'login.php');
}
?>

</body>

</html>