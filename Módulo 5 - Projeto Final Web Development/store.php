<?php
session_start();
include('api.php');
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

    <title>Projeto Final Mercearia</title>
</head>

<body>
    <script>
        $(document).ready(function () {
            <?php
            $getProductTypes();
            $getProducts();
            ?>
        });
    </script>

    <!-- Header-->
    <?php require('header.php'); ?>
    <!-- Page content-->
    <div id="products-section" class="d-flex align-top">
        <!-- category selector -->
        <div id="category-search-section" class="search-section d-none d-sm-block">
            <ul class="list-group" style="width: 250px">
                <li class="list-group-item">
                    <div class="ms-2 me-auto">
                        <form method="GET">
                            <?php inputField("Pesquisar artigo", "searchItemsInput", "text", "", "searchItemsInput", "this.form.submit()", ""); ?>
                        </form>
                    </div>
                </li>
                <form method="POST" action="store.php">
                    <li class="list-group-item">
                        <button type="submit" name="removeGet" class="submit button">Todas</button>
                    </li>
                </form>
                <?php
                foreach ($_SESSION['productTypes'] as $productType) {
                    echo '
                    <form method="GET">
                        <li class="list-group-item">
                                <input name="productTypeSelected" value="' . $productType['id'] . '" hidden>
                                <button  class="submit button"> ' . $productType['name'] . '</button>
                        </li>
                    </form>';
                }
                ?>
            </ul>

        </div>
        <!-- product list -->
        <?php
        if ($_SESSION['products']) {
            ?>

            <div class="row" style="align-content: flex-start">

                <?php
                // echo "<pre>", var_dump($_SESSION['cart']), "</pre>";
                // echo "<pre>", var_dump($_SESSION['teste']), "</pre>";
                // echo "<pre>", var_dump($_SESSION['orderid']), "</pre>";
                // echo "<pre>", var_dump($_SESSION['tpe']), "</pre>";
                // echo "<pre>", var_dump($_SESSION['tp1']), "</pre>";
                // echo "<pre>", var_dump($_SESSION['tp2']), "</pre>";
            

                foreach ($_SESSION['products'] as $product) {
                    $productsID = $product['id'];

                    echo '
                            <form class="form" method="POST" action="store.php#form-anchor-' . $product['id'] . '" id="form-anchor-' . $product['id'] . '">
                                <img data-fancybox style="height: 200px; autoDimensions: false; width: 100%; object-fit: contain;" src="data:image/jpeg;base64,' . $product['image'] . '">
                                <div class="info-container p-2">
                                    <h4>' . $product['name'] . '</h4>
                                    <h5>' . $product['ppu'] . '€</h5>
                                    <h5>Stock: ' . (int) $product['available_qty'] . '</h5>
                                </div>
                                <div class="input-container">
                                <div>
                                    <input name="action" value="addToCart" hidden>
                                </div>
                                <div>
                                    <input name="productID" value="' . $product['id'] . '" hidden>
                                </div>

                                <button type="submit" class="submit button" id="buyProduct">Adicionar ao carrinho </button>
                                </div>
                            </form>
                        ';
                }
                ?>
                <form method="GET" action="store.php#seeMoreForm" id="seeMoreForm">
                    <button type="submit" class="submit button w-50" id="seeMoreButton">Ver
                        mais</button>
                    <input name="page" value="<?= (isset($_GET['page']) + 1) ? (int) $_GET['page'] + 1 : 1; ?>" hidden>
                </form>
            </div>
            <?php
        } else {
            ?>
            <?php
        }
        printToast('toastProductAddedToCart');
        printToast('toastProductNotAddedToCart');
        ?>
    </div>

    <script>
        Fancybox.bind("[data-fancybox]", {});
    </script>

</body>

</html>