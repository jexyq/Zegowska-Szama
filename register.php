<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

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

<?php require 'includes/footer.php'; ?>