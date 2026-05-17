<?php
require 'includes/auth.php';
require 'includes/db.php';
require 'includes/header.php';

$result = $conn->query("SELECT * FROM products WHERE promo_price IS NOT NULL");
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
                    <?php
                        $isLogged = isset($_SESSION['user_id']);

                        if($isLogged && $product['promo_price']){

                            echo "
                                <p class='text-decoration-line-through text-muted'>
                                    {$product['price']} zł
                                </p>

                                <p class='price text-danger'>
                                    {$product['promo_price']} zł
                                </p>
                            ";

                        } else {

                            echo "
                                <p class='price'>
                                    {$product['price']} zł
                                </p>
                            ";
                        }
                    ?>
                </p>

            </div>

        </div>

    </div>

<?php endwhile; ?>

</div>

<?php
require 'includes/footer.php';
?>