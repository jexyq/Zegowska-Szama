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

            <div class="product-image-wrapper position-relative">
                
                <?php if($product['promo_price'] && isset($_SESSION['user_id'])): ?>
                    <span class="badge bg-danger position-absolute top-0 start-0 end-0 text-center py-2" style="z-index: 2;">
                        PROMOCJA
                    </span>
                <?php endif; ?>

                <img 
                    src="assets/img/<?= $product['image']; ?>"
                    class="card-img-top <?= (!file_exists('assets/img/' . $product['image'])) ? 'mt-5' : ''; ?>"  <?php //sprawdzenie czy zdjecie jest puste i dodanie marginesu, bo jezeli bylo to promocja zaslaniala text z "alt"?>
                    alt="Zdjęcie produktu <?= $product['name']; ?>"
                >

            </div>

            <div class="card-body d-flex flex-column">

                <h5 class="card-title">
                    <?= $product['name']; ?>
                </h5>

                <p class="card-text">
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

                <p>
                    Dostepnych:
                    <?= $product['stock']; ?>
                </p>

                <button 
                    class="btn btn-success mt-auto add-to-cart"
                    data-id="<?= $product['id']; ?>"
                    data-name="<?= $product['name']; ?>"
                    data-price="<?= (isset($_SESSION['user_id']) && !empty($product['promo_price'])) ? $product['promo_price'] : $product['price']; ?>"
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