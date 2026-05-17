<?php
require 'includes/db.php';
require 'includes/header.php';

$result = $conn->query("SELECT * FROM products");
?>

<h1 class="mb-4">
    Produkty
</h1>

<input 
    type="text"
    id="searchInput"
    class="form-control mb-4"
    placeholder="Szukaj produktu..."
>

<div class="row" id="productsContainer">

<?php while($product = $result->fetch_assoc()): ?>

    <div class="col-md-4 mb-4 product-card">

        <div class="card shadow h-100">

            <img 
                src="assets/img/<?= $product['image']; ?>"
                class="card-img-top"
                alt="Zdjecie produktu <?= $product['name']; ?>"
            >

            <div class="card-body d-flex flex-column">

                <h5 class="card-title">
                    <?= $product['name']; ?>
                </h5>

                <p class="card-text">
                    <?= $product['description']; ?>
                </p>

                <p class="price">
                    <?= $product['price']; ?> zł
                </p>

                <p>
                    Dostepnych:
                    <?= $product['stock']; ?>
                </p>

                <?php if($product['is_promo']): ?>
                    <span class="badge bg-danger mb-3">
                        PROMOCJA
                    </span>
                <?php endif; ?>

                <button 
                    class="btn btn-success mt-auto add-to-cart"
                    data-id="<?= $product['id']; ?>"
                    data-name="<?= $product['name']; ?>"
                    data-price="<?= $product['price']; ?>"
                >
                    Dodaj do koszyka
                </button>

            </div>

        </div>

    </div>

<?php endwhile; ?>

</div>

<script>

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function(){

    const value = this.value.toLowerCase();

    const cards = document.querySelectorAll('.product-card');

    cards.forEach(card => {

        card.style.display =
            card.innerText.toLowerCase().includes(value)
            ? 'block'
            : 'none';

    });

});

</script>

<?php
require 'includes/footer.php';
?>