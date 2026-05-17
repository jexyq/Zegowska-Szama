<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/zegowska-szama/assets/css/style.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/zegowska-szama/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/zegowska-szama/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/zegowska-szama/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/zegowska-szama/assets/img/favicon/site.webmanifest">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a 
            class="navbar-brand d-flex align-items-center gap-2"
            href="/zegowska-szama/index.php"
        >

            <img
                src="/assets/img/logo.png"
                alt="Logo"
                style="height: 40px;"
            >

            <span>
                Zegowska Szama
            </span>

        </a>

        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/zegowska-szama/products.php">
                        Produkty
                    </a>
                </li>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/zegowska-szama/promotions.php">
                            Promocje
                        </a>
                    </li>

                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="/zegowska-szama/cart.php">
                        Koszyk 🛒 <span id="cart-count"></span>
                    </a>
                </li>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <?php if($_SESSION['user_role'] === 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/zegowska-szama/admin/dashboard.php">
                                Admin
                            </a>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/zegowska-szama/logout.php">
                            Wyloguj
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/zegowska-szama/login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/zegowska-szama/register.php">
                            Rejestracja
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

<div class="container mt-4">