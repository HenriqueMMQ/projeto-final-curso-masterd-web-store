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
            $(document).ready(function() {
                <?php
                $getOrders();
                ?>
            });
        </script>

        <!-- Sidebar-->
        <?php include('sidebar.php'); ?>
        <!-- Header-->
        <?php include('header.php'); ?>
        <!-- Page content-->
        <div id="page-content-wrapper" style="padding: 40px">

            <h1>Encomendas</h1>

            <div class="me-auto form-control w-25 mt-4">
                <div class="fw-bold">Pesquisa</div>

                <form method="GET">
                    <?php inputField("Nome do comprador ou ID da encomenda", "searchOrdersInput", "text", "", "searchOrdersInput", "this.form.submit()", "new-name"); ?>
                </form>
            </div>
            <form method="POST">
                <li class="list-group-item mt-4">
                    <button type="submit" name="removeGet" class="submit button" style="width: 10%;">Mostrar tudo</button>
                </li>
            </form>
            <div class="table-responsive border-radius mt-4">
                <table class="table table-borderless table-hover table-warning align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do comprador</th>
                            <th>Endereço</th>
                            <th>Data de Nascimento</th>
                            <th>Preço total</th>
                            <th ></th>
                            <!-- colspan="3" style="text-align: center;" Ação -->
                        </tr>
                    </thead>
                    <?php
                    foreach ($_SESSION['orders'] as $order) {
                        echo '<tr>
                        <th name="orderID" value="' . $order['id'] . '">' . $order['id'] . '</th>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order['id'] . ' " hidden><div></div><td>
                        <input type="text" name="orderName" class="form-control"  value="' . $order['buyer_name'] . '"> </input> </td></form>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order['id'] . ' " hidden><td>
                        <input type="text" class="form-control" name="orderAvailableQuantity" value="' . $order['buyer_address'] . '"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order['id'] . ' " hidden><td>
                        <input type="date" class="form-control" name="orderPricePerUnit" value="' . $order['buyer_date_of_birth'] . '"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="orderID" value=" ' . $order['id'] . ' " hidden><td>
                        <input type="number" class="form-control" name="orderPricePerUnit" value="' . $order['total_price'] . '"> </input></td></form>';

                        // echo '<td style="text-align: center;"><a class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i></a></td>';
                        // echo '<td style="text-align: center;"><a class="btn btn-sm btn-success"><i class="fas fa-solid fa-check"></i></a></td>';
                        echo '<td style="text-align: center;"><form method="GET" action="order_search.php"><input name="orderID" value="' . $order['id'] . '" hidden><button class="btn btn-sm btn-success"><i class="fas fa-solid fa-eye"></i></button></form></td>';
                    }
                    ?>
                </table>
            </div>
        </div>
        <script>
            Fancybox.bind("[data-fancybox]", {});
        </script>
    </body>

    </html>

<?php
    printToast('toastorderCompleted');
} else {
    header('Location: ' . 'login.php');
}
?>