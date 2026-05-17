<?php
require 'includes/header.php';
?>

<div class="bg-dark text-white p-5 rounded-4 shadow-lg mb-5">

    <div class="container py-5">

        <h1 class="display-4 fw-bold">
            🍔 Zegowska Szama
        </h1>

        <p class="fs-4 mt-3">
            Zamawiaj jedzenie online ze szkolnego sklepiku.
        </p>

        <div class="mt-4 d-flex flex-column flex-sm-row gap-2">

            <a href="products.php" class="btn btn-success btn-lg">
                Produkty
            </a>

            <?php if(!isset($_SESSION['user_id'])): ?>

                <a href="register.php" class="btn btn-outline-light btn-lg">
                    Rejestracja
                </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<div class="row text-center">

    <div class="col-md-4 mb-4">

        <div class="card shadow p-4 h-100">

            <h3>⚡ Szybkie zamowienia</h3>

            <p>
                Zamawiaj online i odbieraj w sklepiku.
            </p>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card shadow p-4 h-100">

            <h3>🔥 Promocje</h3>

            <p>
                Specjalne oferty dla zalogowanych uzytkownikow.
            </p>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card shadow p-4 h-100">

            <h3>📱 Responsywnosc</h3>

            <p>
                Aplikacja dziala na telefonach i komputerach.
            </p>

        </div>

    </div>

</div>

<?php
require 'includes/footer.php';
?>