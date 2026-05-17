<?php
session_start();
require 'includes/db.php';
require 'includes/header.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows === 1){

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: index.php");
            exit();

        } else {
            $message = "Nieprawidłowe hasło.";
        }

    } else {
        $message = "Użytkownik nie istnieje.";
    }
}
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="mb-4 text-center">
                        Logowanie
                    </h2>

                    <?php if($message): ?>
                        <div class="alert alert-danger">
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

                        <button class="btn btn-success w-100">
                            Zaloguj
                        </button>

                    </form>

                    <div class="mt-3 text-center">

                        <a href="register.php">
                            Nie masz konta?
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require 'includes/footer.php'; ?>