<?php
require '../includes/admin_auth.php';
require '../includes/db.php';
require '../includes/header.php';

if(isset($_POST['status'])){

    $status = $_POST['status'];
    $id = $_POST['order_id'];

    $stmt = $conn->prepare("
        UPDATE orders
        SET status = ?
        WHERE id = ?
    ");

    $stmt->bind_param("si", $status, $id);

    $stmt->execute();
    $success = "Status zmieniony.";
}

$result = $conn->query("
    SELECT orders.*, users.email
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.created_at DESC
");
?>

<h1 class="mb-4">
    📦 Zamówienia
</h1>

<?php if(isset($success)): ?>

    <div class="alert alert-success">
        <?= $success ?>
    </div>

<?php endif; ?>

<div class="table-responsive">

<table class="table table-bordered bg-white">

    <thead>

        <tr>
            <th>ID</th>
            <th>Użytkownik</th>
            <th>Status</th>
            <th>Data</th>
            <th>Szczegóły</th>
        </tr>

    </thead>

    <tbody>

    <?php while($order = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $order['id']; ?></td>

            <td><?= $order['email']; ?></td>

            <td>

                <form method="POST" class="d-flex">

                    <input 
                        type="hidden"
                        name="order_id"
                        value="<?= $order['id']; ?>"
                    >

                    <select name="status" class="form-select">

                        <option value="oczekujace"
                            <?= $order['status'] == 'oczekujace' ? 'selected' : ''; ?>>
                            oczekujace
                        </option>

                        <option value="w_realizacji"
                            <?= $order['status'] == 'w_realizacji' ? 'selected' : ''; ?>>
                            w_realizacji
                        </option>

                        <option value="gotowe"
                            <?= $order['status'] == 'gotowe' ? 'selected' : ''; ?>>
                            gotowe
                        </option>

                    </select>

                    <button class="btn btn-success ms-2">
                        Zapisz
                    </button>

                </form>

            </td>

            <td><?= $order['created_at']; ?></td>

            <td>

                <?php

                $order_id = $order['id'];

                $items = $conn->query("
                    SELECT order_items.*, products.name
                    FROM order_items
                    JOIN products ON order_items.product_id = products.id
                    WHERE order_items.order_id = $order_id
                ");

                while($item = $items->fetch_assoc()){

                    echo "
                        <div>
                            {$item['name']}
                            x {$item['quantity']}
                        </div>
                    ";
                }

                ?>

            </td>

        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</div>

<?php
require '../includes/footer.php';
?>