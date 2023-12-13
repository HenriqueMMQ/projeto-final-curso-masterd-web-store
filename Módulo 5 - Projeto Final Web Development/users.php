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
                $getUsers();
                ?>
            });
        </script>

        <!-- Sidebar-->
        <?php include('sidebar.php'); ?>
        <!-- Header-->
        <?php include('header.php'); ?>
        <!-- Page content-->
        <div id="page-content-wrapper" style="padding: 40px">
            <h1>Utilizadores</h1>

            <button type="button" class="submit button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo" style="width: 10%; border: 0;">Adicionar Utilizador</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar um novo utilizador</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nome do utilizador:</label>
                                    <?php inputField("Nome do utilizador", "newUserName", "text", "", "newUserName", "", "new-name"); ?>

                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Username:</label>
                                    <?php inputField("Username do utilizador", "newUserUsername", "text", "", "newUserUsername", "", "new-username"); ?>

                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Password:</label>
                                    <?php inputField("Password do utilizador", "newUserPassword", "password", "", "newUserPassword", "", "new-password"); ?>
                                </div>
                                <input name="action" value="registerNewUser" hidden>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div>
                <form method="POST">
                    <li class="list-group-item">
                        <button type="submit" name="removeGet" class="submit button" style="width: 10%;">Mostrar
                            todos</button>
                    </li>
                </form>
            </div>
            <div class="me-auto form-control w-25 mt-4">
                <div class="fw-bold ">Pesquisa</div>

                <form method="GET">
                    <?php inputField("Nome do utilizador", "searchUserInput", "text", "", "searchUserInput", "this.form.submit()", "new-name"); ?>
                </form>

            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover table-warning align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Nome de Utilizador</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($_SESSION['users'] as $user) {
                        echo '<tr>
                        <th name="userID" value="' . $user['id'] . '">' . $user['id'] . '</th>';

                        echo '<form class="form" method="POST"><input name="userID" value=" ' . $user['id'] . ' " hidden><input name="action" value="updateUserName" hidden><td>
                        <input type="text" name="userName" class="form-control"  value="' . $user['name'] . '" onchange="this.form.submit()"> </input> </td></form>';

                        echo '<form class="form" method="POST"><input name="userID" value=" ' . $user['id'] . ' " hidden><input name="action" value="updateUserUsername" hidden><td>
                        <input type="text" class="form-control" name="userUsername" value="' . $user['username'] . '" onchange="this.form.submit()"> </input></td></form>';

                        echo '<form class="form" method="POST"><input name="userID" value=" ' . $user['id'] . ' " hidden><input name="action" value="updateUserPassword" hidden><td>
                        <input type="password" class="form-control" name="userPassword" placeholder="Alterar a palavra-passe deste utilizador" onchange="this.form.submit()"> </input></td></form>';
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

    printToast('toastUserAdded');
    printToast('toastUserNotAdded');
    printToast('toastUserUpdated');
    printToast('toastUserNotUpdated');
} else {
    header('Location: ' . 'login.php');
}
?>