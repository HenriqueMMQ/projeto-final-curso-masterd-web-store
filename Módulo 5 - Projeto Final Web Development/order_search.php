<?php
session_start();
require('api.php');
if ($_SESSION["user"]) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
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

        <title>Artigos</title>
    </head>

    <body>
        <script>
            $(document).ready(function () {
                <?php
                $getOrderLines();
                $getOrder();
                ?>
            });
        </script>

        <!-- Header-->
        <?php include('header.php'); ?>
        <!-- Page content-->
        <div id="page-content-wrapper" style="padding: 40px">


            <h2>Encomenda nº
                <?= $_GET['orderID'] ?>
            </h2>
            <h6 class="text-muted">Nome:
                <?= $_SESSION['order']['buyer_name'] ?>
            </h6>
            <h6 class="text-muted">Morada:
                <?= $_SESSION['order']['buyer_address'] ?>
            </h6>

            <div class="table-responsive border-radius mt-4">
                <table class="table table-borderless table-hover table-warning align-middle">
                    <thead>
                        <tr>
                            <th>Artigo nº</th>
                            <th>Nome do artigo</th>
                            <th>Quantidade</th>
                            <th>Preço total dos artigos</th>
                            <!-- <th colspan="3" style="text-align: center;">Ação</th> -->
                        </tr>
                    </thead>
                    <?php
                    foreach ($_SESSION['orderLines'] as $order_line) {
                        echo '<tr>
                        <th name="orderID" value="' . $order_line['id'] . '">' . $order_line['id'] . '</th>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order_line['id'] . ' " hidden><td>
                        <input type="text" class="form-control" name="orderAvailableQuantity" value="' . $order_line['name'] . '"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order_line['id'] . ' " hidden><td>
                        <input type="number" class="form-control" name="orderPricePerUnit" value="' . $order_line['quantity'] . '"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order_line['id'] . ' " hidden><td>
                        <input type="number" class="form-control" name="orderPricePerUnit" value="' . $order_line['quantity'] * $order_line['ppu'] . '"> </input></td></form>';

                        // echo '<td style="text-align: center;"><a class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i></a></td>';
                        // echo '<td style="text-align: center;"><a class="btn btn-sm btn-success"><i class="fas fa-solid fa-check"></i></a></td>';
                    }
                    ?>
                </table>
            </div>
            <script>
                Fancybox.bind("[data-fancybox]", {});
            </script>
    </body>

    </html>

    <?php

    Toast('toastorderCompleted');
} else {
    header('Location: ' . 'login.php');
}
?>