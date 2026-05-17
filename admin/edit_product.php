<?php
require '../includes/admin_auth.php';
require '../includes/db.php';
require '../includes/header.php';

if(!isset($_GET['id'])){
    header("Location: products.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT * FROM products
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$product = $result->fetch_assoc();

if(!$product){
    die("Produkt nie istnieje.");
}

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $promo_price = !empty($_POST['promo_price'])
        ? $_POST['promo_price']
        : null;

    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("
        UPDATE products
        SET
            name = ?,
            description = ?,
            price = ?,
            promo_price = ?,
            stock = ?,
            image = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssddisi",
        $name,
        $description,
        $price,
        $promo_price,
        $stock,
        $image,
        $id
    );

    if($stmt->execute()){

        $success = "Produkt zostal zaktualizowany.";

        $stmt = $conn->prepare("
            SELECT * FROM products
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $product = $result->fetch_assoc();
    }
}
?>

<div class="row justify-content-center">

    <div class="col-12 col-md-8 col-lg-6">

        <div class="card shadow p-4">

            <h1 class="mb-4">
                ✏️ Edytuj produkt
            </h1>

            <?php if(isset($success)): ?>

                <div class="alert alert-success">
                    <?= $success ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Nazwa produktu
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= $product['name']; ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Opis
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    ><?= $product['description']; ?></textarea>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cena
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            class="form-control"
                            value="<?= $product['price']; ?>"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cena promocyjna
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="promo_price"
                            class="form-control"
                            value="<?= $product['promo_price']; ?>"
                        >

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Stan magazynowy
                        </label>

                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            value="<?= $product['stock']; ?>"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Zdjęcie
                        </label>

                        <input
                            type="text"
                            name="image"
                            class="form-control"
                            value="<?= $product['image']; ?>"
                            required
                        >

                    </div>

                </div>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-success w-100"
                >
                    Zapisz zmiany
                </button>

            </form>

        </div>

    </div>

</div>

<?php
require '../includes/footer.php';
?>