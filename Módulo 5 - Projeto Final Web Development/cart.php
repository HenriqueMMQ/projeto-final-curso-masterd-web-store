<?php
session_start();
require('api.php');
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
    <link rel="stylesheet" href="./styles/form_style.css">

    <title>Carrinho</title>
</head>

<body>
    <?php include('header.php'); ?>

    <div style="padding: 40px;">
        <!-- Header-->
        <table class="table my-3">
            <a href="store.php" class="btn btn-sm btn-warning mt-2 mx-2">Voltar para a loja</a>
            <form method="POST"><button type="submit" name="emptyCart" class="btn btn-sm btn-danger mt-2">Limpar
                    carrinho</button></form>
            <thead>
                <tr class="text-center">
                    <th>Nome do artigo</th>
                    <th>Quantidade</th>
                    <th>Imagem</th>
                    <th>Preço p/unidade</th>
                    <th>Preço total artigo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['cart'])):

                    foreach ($_SESSION['cart'] as $product):
                        ?>
                        <tr class="align-middle ">
                            <td>
                                <?= $product['name'] ?>
                            </td>
                            <td>
                                <form method="POST" style="text-align: -webkit-center;">
                                    <input class="form-control text-center" style="width: 100px; " type="number" name="qty"
                                        min="0" max="999"
                                        onchange="if(value<1) value=1; if(value><?= (int) $product['available_qty']; ?>) value=<?= (int) $product['available_qty']; ?>; this.form.submit();"
                                        value="<?= $product['qty']; ?>">
                                    <input name="action" value="updateCart" hidden>
                                    <input name="productID" value="<?php echo $product['id'] ?>" hidden>
                                </form>
                                <div class="mt-2 text-center" style="text-align: -webkit-center;">Disponivel:
                                    <?= (int) $product['available_qty']; ?>
                                </div>
                            </td>
                            <td><img data-fancybox="image_group" style="height: 100px;  width: 100%; object-fit: contain;"
                                    src="data:image/jpeg;base64, <?= $product['image'] ?>"></td>
                            <td style="text-align: -webkit-center;">
                                <?= $product['ppu'] ?>€
                            </td>
                            <td style="text-align: -webkit-center;">
                                <?= $product['ppu'] * $product['qty'] ?>€
                            </td>
                            <form method="POST">
                                <td><button class="btn btn-sm btn-danger">X</button>
                                    <input name="productID" value=" <?php echo $product['id'] ?>" hidden>
                                    <input name="action" value="removeFromCart" hidden>
                                </td>
                            </form>
                        </tr>

                        <?php
                    endforeach;
                endif;

                ?>
            </tbody>
        </table>
        <form method="POST">
            <button type="button" class="submit button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo" style="width: 20%; border: 0;"
                onclick="<?php if (!isset($_SESSION['cart']) or count($_SESSION['cart']) == 0)
                    die; ?>">Confirmar
                compra</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Finalizar a compra</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nome do comprador:</label>
                                    <?php inputField("Nome", "buyerName", "text", "", "buyerName", "", "new-name"); ?>

                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Data de nascimento:*</label>
                                    <p class="small">Tem que ser maior de 18 anos para concluir a compra.</p>
                                    <?php inputField("Data", "buyerDateOfBirth", "date", "", "buyerDateOfBirth", "", "new-date"); ?>

                                </div>
                                <div class="mb-3">
                                    <label for="recipient-quantity-available" class="col-form-label">Endereço de
                                        entrega:</label>
                                    <?php inputField("Endereço", "buyerAddress", "text", "", "buyerAddress", "", "new-address"); ?>
                                </div>
                                <input name="action" value="confirmOrder" hidden>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Confirmar compra</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        foreach ($_SESSION['cart'] as $cart) {
            $totalPriceEach = $cart['ppu'] * $cart['qty'];
            $totalPrice = $totalPrice + $totalPriceEach;
        }
        ?>

        <button class="submit button" style="width: 20%; border: 0;"> Total:
            <?= $totalPrice ?> €
        </button>
    </div>
    <?php
    // echo "<pre>products in cart <br>", var_dump($_SESSION['pic']), "</pre>";
    // echo "<pre>products in cart 2 <br>", var_dump($_SESSION['pic1']), "</pre>";
    // echo "<pre>", var_dump($_SESSION['teste1']), "</pre>";
    // echo "<pre>", var_dump($_SESSION['teste2']), "</pre>";
    // echo "<pre>", var_dump($_SESSION['cart']), "</pre>";
    
    printToast('toastCartUpdated');
    printToast('toastCartNotUpdated');

    ?>
    <script>
        Fancybox.bind("[data-fancybox]", {});
    </script>

</body>

</html>