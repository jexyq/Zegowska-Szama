<?php
require 'includes/auth.php';
require 'includes/db.php';
require 'includes/header.php';

$result = $conn->query("SELECT * FROM products WHERE is_promo = 1");
?>

<h1 class="mb-4">
    🔥 Promocje
</h1>

<div class="row">

<?php while($product = $result->fetch_assoc()): ?>

    <div class="col-md-4 mb-4">

        <div class="card shadow h-100">

            <img 
                src="assets/img/<?= $product['image']; ?>"
                class="card-img-top"
                alt="Zdjecie produktu <?= $product['name']; ?>"
            >

            <div class="card-body">

                <h5>
                    <?= $product['name']; ?>
                </h5>

                <p>
                    <?= $product['description']; ?>
                </p>

                <p class="price">
                    <?= $product['price']; ?> zł
                </p>

            </div>

        </div>

    </div>

<?php endwhile; ?>

</div>

<?php
require 'includes/footer.php';
?>