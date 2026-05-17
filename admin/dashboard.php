<?php
require '../includes/admin_auth.php';
require '../includes/db.php';
require '../includes/header.php';

$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

$products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

$orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
?>

<h1 class="mb-4">
    ⚙️ Panel administratora
</h1>

<div class="row">

    <div class="col-md-4 mb-4">

        <div class="card shadow text-center p-4">

            <h3>Uzytkownicy</h3>

            <h1><?= $users ?></h1>

            <a href="users.php" class="btn btn-dark mt-3">
                Zarzadzaj
            </a>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card shadow text-center p-4">

            <h3>Produkty</h3>

            <h1><?= $products ?></h1>

            <a href="products.php" class="btn btn-success mt-3">
                Zarzadzaj
            </a>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card shadow text-center p-4">

            <h3>Zamowienia</h3>

            <h1><?= $orders ?></h1>

            <a href="orders.php" class="btn btn-primary mt-3">
                Zarzadzaj
            </a>

        </div>

    </div>

</div>

<?php
require '../includes/footer.php';
?>