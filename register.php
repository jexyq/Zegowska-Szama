<?php
session_start();
require 'includes/db.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(!empty($email) && !empty($password)){

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        if($stmt->execute()){
            $message = "Konto utworzone!";
        } else {
            $message = "Blad: email moze juz istniec.";
        }

        $stmt->close();
    } else {
        $message = "Uzupelnij wszystkie pola.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="mb-4 text-center">Rejestracja</h2>

                    <?php if($message): ?>
                        <div class="alert alert-info">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Email</label>

                            <input 
                                type="email" 
                                name="email" 
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label>Haslo</label>

                            <input 
                                type="password" 
                                name="password" 
                                class="form-control"
                                required
                            >
                        </div>

                        <button class="btn btn-primary w-100">
                            Zarejestruj
                        </button>

                    </form>

                    <div class="mt-3 text-center">
                        <a href="login.php">
                            Masz juz konto?
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>