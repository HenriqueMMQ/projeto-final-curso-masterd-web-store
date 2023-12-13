<?php
require('./db_connection/db_connection.php');
require_once('input_element.php');
require('toast_script.php');

$action = $_POST['action'];

$getProducts = function () use ($connection) {
    $productType = $_GET['productTypeSelected'];
    $productSearched = $_GET['searchItemsInput'];
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 18;
    $pagination = $page * $itemsPerPage;

    if (($productType == '' || $productType == 'null') and (!$productSearched)) {
        $fetchProducts = "SELECT * FROM products LIMIT $pagination";
    } else if ($productType) {
        $fetchProducts = "SELECT * FROM products WHERE productType LIKE '$productType'";
    } else if ($productSearched) {
        $fetchProducts = "SELECT * FROM products WHERE name LIKE '%$productSearched%' OR id LIKE '%$productSearched%'";
    }

    $result = $connection->query($fetchProducts);

    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['products'] = $rows;
};

$getProductTypes = function () use ($connection) {

    $fetchAllProductTypes = "SELECT * FROM product_types";
    $result = $connection->query($fetchAllProductTypes);

    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['productTypes'] = $row;
};

$getUsers = function () use ($connection) {
    $userSearched = $_GET['searchUserInput'];

    if (($userSearched == 'all' || $userSearched == '' || $userSearched == 'null')) {
        $fetchProducts = "SELECT * FROM users";
    } else if ($userSearched) {
        $fetchProducts = "SELECT * FROM users WHERE id LIKE '%$userSearched%' OR name LIKE '%$userSearched%' OR username LIKE '%$userSearched%'";
    }
    $result = $connection->query($fetchProducts);

    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['users'] = $row;
};

$getOrders = function () use ($connection) {
    $ordersSearched = $_GET['searchOrdersInput'];

    if (!$ordersSearched or $ordersSearched == '') {
        $fetchOrders = "SELECT * FROM orders";
    } else {
        $fetchOrders = "SELECT * FROM orders WHERE id LIKE '%$ordersSearched%' OR buyer_name LIKE '%$ordersSearched%'";
    }

    $result = $connection->query($fetchOrders);

    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['orders'] = $rows;
};

$getOrderLines = function () use ($connection) {
    $ordersSearched = $_GET['orderID'];

    $fetchOrderLines = "SELECT order_lines.*, products.* FROM order_lines LEFT JOIN products ON order_lines.product_id = products.id WHERE order_id = '$ordersSearched'";

    $result = $connection->query($fetchOrderLines);

    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['orderLines'] = $rows;
};

$getOrder = function () use ($connection) {
    $orderID = $_GET['orderID'];

    $fetchOrder = "SELECT * FROM orders WHERE id = '$orderID'";

    $result = $connection->query($fetchOrder);

    $row = $result->fetch(PDO::FETCH_ASSOC);

    $_SESSION['order'] = $row;
};

if ($action == "login") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username";

    try {
        $loginQuery = $connection->prepare($sql);
        $loginQuery->execute(['username' => $username]);

        $checkUser = $loginQuery->fetch(PDO::FETCH_ASSOC);

        $pwd_check = password_verify($password, $checkUser["password"]);
        $_SESSION['userpass'] = $pwd_check;

        if ($checkUser && $pwd_check) {
            $_SESSION['user'] = $checkUser;

            Toast('toastUserSignedIn', 'Sessão iniciada', '#007a00');
            header('Location: ' . 'admin.php');
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        Toast('toastUserSignInError', 'Erro. Não foi possível iniciar sessão', '#BA2728');
    }
}

if ($action == "registerNewUser") {

    $name = $_POST['newUserName'];
    $username = $_POST['newUserUsername'];
    $password = $_POST['newUserPassword'];
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, username, password) VALUES (:name, :username, :passHash)";

    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['name' => $name, 'username' => $username, 'passHash' => $passHash]);

        Toast('toastUserAdded', 'Utilizador adicionado', '#007a00');

    } catch (\Throwable $th) {

        Toast('toastUserNotAdded', 'Erro. Não foi possível adicionar o utilizador', '#BA2728');
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
}


if ($action == "add_product") {

    $name = $_POST['newProductName'];
    $productType = $_POST['newProductType'];
    $quantity = str_replace(',', '.', $_POST['newProductQuantity']);
    $ppu = str_replace(',', '.', $_POST['newProductPpu']);
    $image = $_FILES['image']['tmp_name'] != NULL ? base64_encode(file_get_contents($_FILES['image']['tmp_name'])) : NULL;

    try {

        $productQuery = $connection->prepare("INSERT INTO products ( name, productType, available_qty, ppu, image ) VALUES ( :name, :productType, :quantity, :ppu, :image)");
        $productQuery->execute(['name' => $name, 'productType' => $productType, 'quantity' => $quantity, 'ppu' => $ppu, 'image' => $image]);

        Toast('toastProductAdded', 'Produto adicionado', '#007a00');

        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastProductNotAdded', 'Erro. Não foi possível adicionar o produto', '#BA2728');
    }
}

if ($action == "updateProductName") {

    $productID = $_POST['productID'];
    $name = $_POST['productName'];

    $sql = "UPDATE products SET name = :name WHERE id = :productID";

    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['name' => $name, 'productID' => $productID]);

        Toast('toastProductUpdated', 'Artigo alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastProductNotUpdated', 'Erro. Não foi possível editar o artigo', '#BA2728');
    }
}

if ($action == "updateProductAvailableQuantity") {

    $productID = $_POST['productID'];
    $productAvailableQuantity = $_POST['productAvailableQuantity'];

    $sql = "UPDATE products SET available_qty = :productAvailableQuantity WHERE id = :productID";

    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['productAvailableQuantity' => $productAvailableQuantity, 'productID' => $productID]);

        Toast('toastProductUpdated', 'Artigo alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastProductNotUpdated', 'Erro. Não foi possível editar o artigo', '#BA2728');
    }
}

if ($action == "updateProductPricePerUnit") {

    $productID = $_POST['productID'];
    $productPricePerUnit = $_POST['productPricePerUnit'];

    $sql = "UPDATE products SET ppu = :productPricePerUnit WHERE id = :productID";

    try {

        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['productPricePerUnit' => $productPricePerUnit, 'productID' => $productID]);

        $sql = "SELECT name FROM products WHERE id = :productID";

        $query = $connection->prepare($sql);
        $query->execute(['productID' => $productID]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        Toast('toastProductUpdated', 'Preço por unidade do artigo ' . $row['name'] . ' alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastProductNotUpdated', 'Erro. Não foi possível editar o artigo', '#BA2728');
    }
}

if ($action == "updateProductType") {

    $productID = $_POST['productID'];
    $productType = $_POST['productType'];

    $sql = "UPDATE products SET productType = :productType WHERE id = :productID";

    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['productType' => $productType, 'productID' => $productID]);

        Toast('toastProductUpdated', 'Artigo alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastProductNotUpdated', 'Erro. Não foi possível editar o artigo', '#BA2728');
    }
}

if ($action == "updateUserName") {

    $userID = $_POST['userID'];
    $userName = $_POST['userName'];

    $sql = "UPDATE users SET name = :userName WHERE id = :userID";
    Toast('toastUserUpdated', 'Utilizador alterado', '#007a00');

    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['userName' => $userName, 'userID' => $userID]);

        Toast('toastUserUpdated', 'Utilizador alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastUserNotUpdated', 'Erro. Não foi possível editar o utilizador', '#BA2728');
    }
}

if ($action == "updateUserUsername") {

    $userID = $_POST['userID'];
    $userUsername = $_POST['userUsername'];

    $sql = "UPDATE users SET username = :userUsername WHERE id = :userID";
    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['userUsername' => $userUsername, 'userID' => $userID]);

        Toast('toastUserUpdated', 'Utilizador alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {


        Toast('toastUserNotUpdated', 'Erro. Não foi possível editar o utilizador', '#BA2728');
    }
}

if ($action == "updateUserPassword") {

    $userID = $_POST['userID'];
    $userPassword = $_POST['userPassword'];
    $passHash = password_hash($userPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = :userPassword WHERE id = :userID";
    try {
        $insertUserQuery = $connection->prepare($sql);
        $insertUserQuery->execute(['userPassword' => $passHash, 'userID' => $userID]);

        Toast('toastUserUpdated', 'Utilizador alterado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastUserNotUpdated', 'Erro. Não foi possível editar o utilizador', '#BA2728');
    }
}

if ($action == "addToCart") {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $productID = $_POST['productID'];

    $fetchProduct = "SELECT id, name, ppu, available_qty, image FROM products WHERE id = :productID";

    try {
        $query = $connection->prepare($fetchProduct);
        $query->execute(['productID' => $productID]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $productInCart = array_column($_SESSION['cart'], 'id');

        if (in_array($productID, $productInCart)) {
            $index = array_search($productID, $productInCart);
            if ($_SESSION['cart'][$index]['qty'] + 1 > $row['available_qty']) {
                throw new Exception('Stock insuficiente');
            } else {
                $_SESSION['cart'][$index]['qty'] += 1;
            }
        } else {
            $row['qty'] = 1;

            $currentCart = $_SESSION['cart'];
            $currentCart[] = $row;
            $_SESSION['cart'] = $currentCart;
        }
        Toast('toastProductAddedToCart', '' . $row['name'] . ' adicionado ao carrinho.', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (Throwable $e) {

        Toast('toastProductNotAddedToCart', '' . $e->getMessage() . '. Não foi possível adicionar o artigo.', '#BA2728');
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
}

if ($action == "removeFromCart") {
    $productID = $_POST['productID'];

    $newCart = $_SESSION['cart'];

    $newCart = array_filter($newCart, function ($element) {
        if ($element['id'] != $_POST['productID']) {
            return TRUE;
        }
        return FALSE;
    });

    $_SESSION['cart'] = $newCart;

    header('Location: ' . $_SERVER['PHP_SELF']);
}

if ($action == "updateCart") {
    $productID = $_POST['productID'];
    $cart = $_SESSION['cart'];
    $newCart = [];
    $qty = $_POST['qty'];

    foreach ($cart as $product) {
        if ($product['id'] == $productID) {
            $product['qty'] = $qty;
        }
        $newCart[] = $product;
    }
    $_SESSION['cart'] = $newCart;

    try {

        Toast('toastCartUpdated', 'Carrinho atualizado', '#007a00');
        header('Location: ' . $_SERVER['PHP_SELF']);
    } catch (\Throwable $th) {

        Toast('toastCartNotUpdated', 'Erro. Não foi possível atualizar o carrinho', '#BA2728');
    }
}

if ($action == 'confirmOrder') {
    $buyerDOB = $_POST['buyerDateOfBirth'];
    $buyerName = $_POST['buyerName'];
    $buyerAddress = $_POST['buyerAddress'];


    foreach ($_SESSION['cart'] as $cart) {
        $totalPriceEach = $cart['ppu'] * $cart['qty'];
        $totalPrice = $totalPrice + $totalPriceEach;
    }

    if (time() < strtotime('+18 years', strtotime($buyerDOB))) {
        echo 'Client is under 18 years of age.';
        exit;
    } else {
        $sql = 'INSERT INTO orders (buyer_name, buyer_address, buyer_date_of_birth, total_price) VALUES (:buyerName, :buyerAddress, :buyerDOB, :totalPrice)';
        $insertUserOrder = $connection->prepare($sql);
        $insertUserOrder->execute(['buyerName' => $buyerName, 'buyerAddress' => $buyerAddress, 'buyerDOB' => $buyerDOB, 'totalPrice' => $totalPrice]);

        $fetchOrderID = "SELECT id FROM orders WHERE id=(SELECT max(id) FROM orders)";
        $result = $connection->query($fetchOrderID);
        $lastRow = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['orderid'] = $lastRow;

        $sql = 'INSERT INTO order_lines (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)';

        foreach ($_SESSION['cart'] as $cart) {
            $insertOrderLine = $connection->prepare($sql);
            $insertOrderLine->execute(['order_id' => $lastRow['id'], 'product_id' => $cart['id'], 'quantity' => $cart['qty']]);
        }
        unset($_SESSION['cart']);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['removeGet'])) {
    unset($_GET['productTypeSelected']);
    header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['emptyCart'])) {
    unset($_SESSION['cart']);
    header("location: cart.php");
}


if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ' . 'index.php');
}
