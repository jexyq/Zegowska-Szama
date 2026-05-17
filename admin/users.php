<?php
require '../includes/admin_auth.php';
require '../includes/db.php';
require '../includes/header.php';

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    if($id == $_SESSION['user_id']){
        die("Nie możesz usunąć samego siebie.");
    }
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $success = "Użytkownik usunięty.";
}

if(isset($_POST['role'])){

    $id = $_POST['user_id'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("
        UPDATE users
        SET role = ?
        WHERE id = ?
    ");

    $stmt->bind_param("si", $role, $id);

    $stmt->execute();
    $success = "Rola zmieniona.";
}

$result = $conn->query("SELECT * FROM users");
?>

<h1 class="mb-4">
    👤 Użytkownicy
</h1>

<?php if(isset($success)): ?>

    <div class="alert alert-success">
        <?= $success ?>
    </div>

<?php endif; ?>

<div class="table-responsive">

<table class="table table-bordered bg-white">

    <thead>

        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Rola</th>
            <th>Akcje</th>
        </tr>

    </thead>

    <tbody>

    <?php while($user = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $user['id']; ?></td>

            <td><?= $user['email']; ?></td>

            <td>

                <form method="POST" class="d-flex">

                    <input 
                        type="hidden"
                        name="user_id"
                        value="<?= $user['id']; ?>"
                    >

                    <select 
                        name="role"
                        class="form-select"
                    >
                        <option value="user"
                            <?= $user['role'] == 'user' ? 'selected' : ''; ?>>
                            user
                        </option>

                        <option value="admin"
                            <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>
                            admin
                        </option>
                    </select>

                    <button class="btn btn-success ms-2">
                        Zapisz
                    </button>

                </form>

            </td>

            <td>

                <a 
                    href="?delete=<?= $user['id']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Usunac uzytkownika?')"
                >
                    Usuń
                </a>

            </td>

        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</div>

<?php
require '../includes/footer.php';
?>