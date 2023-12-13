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
                $getProducts();
                $getProductTypes();
                ?>
            });
        </script>

        <!-- Sidebar-->
        <?php include('sidebar.php'); ?>
        <!-- Header-->
        <?php include('header.php'); ?>
        <!-- Page content-->
        <div id="page-content-wrapper" style="padding: 40px">
            <h1>Artigos</h1>
            <div>
                <button type="button" class="submit button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo" style="width: 10%; border: 0;">Adicionar Artigo</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar um novo artigo</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nome do artigo:</label>
                                        <?php inputField("Nome do artigo", "newProductName", "text", "", "newProductName", "", "new-name"); ?>

                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-category" class="col-form-label">Categoria:</label>
                                        <select class="form-control" name="newProductType" id="newProductType" required>
                                            <option value="">Selecione uma categoria</option>
                                            <?php
                                            foreach ($_SESSION['productTypes'] as $productType) {
                                                echo
                                                    '<option name="otherUserUsername" value="' . $productType['id'] . '"> ' . $productType['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-quantity-available" class="col-form-label">Quantidade
                                            disponível:</label>
                                        <input type="number" class="form-control" min="0" max="10000" step="0.01"
                                            name="newProductQuantity" id="newProductQuantity" placeholder="Quantidade"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-price-per-unit" class="col-form-label">Preço por
                                            unidade:</label>
                                        <input type="number" class="form-control" min="0" max="1000" step="0.01"
                                            name="newProductPpu" id="newProductPpu" placeholder="Preço por unidade"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-image" class="col-form-label">Imagem:</label>
                                        <?php inputField("", "image", "file", "", "image", "", "new-name"); ?>

                                    </div>

                                    <input name="action" value="add_product" hidden>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form method="POST">
                    <li class="list-group-item">
                        <button type="submit" name="removeGet" class="submit button" style="width: 10%;"> Tudo</button>
                    </li>
                </form>
            </div>
            <div class="me-auto form-control w-25">
                <div class="fw-bold">Pesquisa</div>

                <form method="GET">
                    <?php inputField("Nome ou ID do artigo", "searchItemsInput", "text", "", "searchItemsInput", "this.form.submit()", "new-name"); ?>
                </form>
            </div>
            <div class="table-responsive border-radius mt-4">
                <table class="table table-borderless table-hover table-warning align-middle">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nome</th>
                            <th>quantidade</th>
                            <th>preço</th>
                            <th>Categoria</th>
                            <th>imagem</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($_SESSION['products'] as $product) {
                        echo '<tr>
                        <th name="productID" value="' . $product['id'] . '">' . $product['id'] . '</th>';

                        echo '<form class="form" method="POST"><input name="productID" value=" ' . $product['id'] . ' " hidden><div><input name="action" value="updateProductName" hidden></div><td>
                        <input type="text" name="productName" class="form-control"  value="' . $product['name'] . '" onchange="this.form.submit()"> </input> </td></form>';

                        echo '<form class="form" method="POST"><input name="productID" value=" ' . $product['id'] . ' " hidden><input name="action" value="updateProductAvailableQuantity" hidden><td>
                        <input type="number" class="form-control" name="productAvailableQuantity" value="' . $product['available_qty'] . '" onchange="this.form.submit()"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="productID" value=" ' . $product['id'] . ' " hidden><input name="action" value="updateProductPricePerUnit" hidden><td>
                        <input type="number" class="form-control" name="productPricePerUnit" value="' . $product['ppu'] . '" onchange="this.form.submit()"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="productID" value=" ' . $product['id'] . ' " hidden><input name="action" value="updateProductType" hidden><td>
                        <select class="form-select" name="productType" onchange="this.form.submit()">';

                        foreach ($_SESSION['productTypes'] as $productType) {
                            echo
                                '<option ' . (($product['productType'] == $productType['id']) ? 'selected ' : '') . 'value="' . $productType['id'] . '" > ' . $productType['name'] . '</option>';
                        }

                        '</select></td></form>';

                        echo '<form class="form" method="POST"><td name="productImage"><img data-fancybox="image_group" style="height: 50px; autoDimensions: false; width: 100%; object-fit: contain;" src="data:image/jpeg;base64,' . $product['image'] . '"></td></form></tr>';
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
    printToast('toastProductUpdated');
    printToast('toastProductNotUpdated');
    printToast('toastProductPricePerUnitUpdated');
    printToast('toastProductPricePerUnitNotUpdated');

} else {
    header('Location: ' . 'login.php');
}
?>