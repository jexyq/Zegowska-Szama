<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $pattern = '/^[\x20-\x7E]{8,}$/';

    if(!empty($email) && !empty($password)){

        if(preg_match($pattern, $password)) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $result = $stmt->get_result();

            if($result->num_rows > 0){

                $message = "Podany adres e-mail już istnieje.";

            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

                $stmt->bind_param("ss", $email, $hashedPassword);

                if($stmt->execute()){
                    $message = "Konto zostało utworzone!";

                } else {
                    $message = "Wystapił błąd.";
                    
                }
            }

            $stmt->close();
        }
        else {
            $message = "Hasło musi mieć minimum 8 znaków i zawierać tylko standardowe znaki z klawiatury";
        }
    } else {
        $message = "Uzupełnij wszystkie pola.";
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
                        <div class="alert alert-info perm">
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
                            <label>Hasło</label>

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
                            Masz już konto?
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require 'includes/footer.php'; ?>