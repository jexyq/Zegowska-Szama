<?php
require 'includes/auth.php';
?>

<h1>Witaj <?= $_SESSION['user_email']; ?></h1>

<a href="logout.php">
    Wyloguj
</a>