<?php
require '../includes/admin_auth.php';
?>

<h1>Panel admina</h1>

<p>
Witaj adminie:
<?= $_SESSION['user_email']; ?>
</p>