<nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom">
    <div class="container-fluid p-2">
        <button class="btn" onclick="history.back()"><i class="fas fa-chevron-left"></i></button>
        <a class="btn" href="store.php">Loja</a>
        <div class=" navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Carrinho (<?php if (isset($_SESSION['cart'])) echo count($_SESSION['cart'], COUNT_NORMAL) ?>)</a>
                </li>

            </ul>
        </div>
    </div>
</nav>