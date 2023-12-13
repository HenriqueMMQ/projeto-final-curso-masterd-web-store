<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url, 'index')) {
?>
    <div class="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">X</button>
        <ul class="menu">
            <li>Categorias</li>
            <div class="list-group list-group-flush">
                <form method="GET">
                    <select class="list-group-item list-group-item-action list-group-item-light p-3" style="Cursor: pointer;" name="productTypeSelected" onchange="this.form.submit()">
                        <option <?php echo (($_SESSION['productSelected'] == 'all') ? ' selected ' : '')  ?> value="all">Selecione uma categoria</option>
                        <?php

                        foreach ($_SESSION['productTypes'] as $productType) {
                            echo
                            '<option ' . ((is_array($_SESSION['productSelected']) && $_SESSION['productSelected']['id'] == $productType['id']) ? 'selected' : '') . '  value="' . $productType['id'] . '"> ' . $productType['name'] . '</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
        </ul>
    </div>
<?php
} else if (strpos($url, 'admin') or strpos($url, 'products') or strpos($url, 'users')) {
?>
    <div class="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">X</button>
        <ul class="menu">
            <div class="list-group list-group-flush">
                <a href="orders.php">Encomendas</a>
                <a href="products.php">Artigos</a>
                <a href="users.php">Utilizadores</a>
            </div>
        </ul>
    </div>

<?php
}
?>