<?php
require '../includes/admin_auth.php';
require '../includes/db.php';
require '../includes/header.php';

$error = "";

if(isset($_POST['add'])){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $promo_price = !empty($_POST['promo_price']) ? $_POST['promo_price'] : null;
    $stock = $_POST['stock'];
    $image = $_POST['image'];
    $promo = isset($_POST['is_promo']) ? 1 : 0;

    $stmt = $conn->prepare("
        INSERT INTO products
        (name, description, price, promo_price, stock, image, is_promo)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssdisi",
        $name,
        $description,
        $price,
        $promo_price,
        $stock,
        $image,
        $promo
    );

    $stmt->execute();
    $success = "Produkt dodany!";
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    try{

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $success = "Produkt usuniety.";

    } catch(mysqli_sql_exception $e){

        $error = "Nie mozna usunac produktu, poniewaz istnieje w zamowieniach.";
    }
}

$result = $conn->query("SELECT * FROM products");
?>

<h1 class="mb-4">
    🍔 Produkty
</h1>

<?php if(isset($success)): ?>

    <div class="alert alert-success">
        <?= $success ?>
    </div>

<?php endif; ?>

<?php if(!empty($error)): ?>

    <div class="alert alert-danger">
        <?= $error ?>
    </div>

<?php endif; ?>

<div class="card shadow p-4 mb-5">

    <form method="POST">

        <div class="row">

            <div class="col-md-6 mb-3">

                <input 
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Nazwa produktu"
                    required
                >

            </div>

            <div class="col-md-3 mb-3">

                <input 
                    type="number"
                    step="0.01"
                    name="price"
                    class="form-control"
                    placeholder="Cena"
                    required
                >

            </div>

            <div class="col-md-3 mb-3">

                <input 
                    type="number"
                    step="0.01"
                    name="promo_price"
                    class="form-control"
                    placeholder="Cena promocyjna"
                >

            </div>

        </div>

        <div class="mb-3">

            <textarea 
                name="description"
                class="form-control"
                placeholder="Opis"
            ></textarea>

        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <input 
                    type="number"
                    name="stock"
                    class="form-control"
                    placeholder="Stan magazynowy"
                    required
                >

            </div>

            <div class="col-md-6 mb-3">

                <input 
                    type="text"
                    name="image"
                    class="form-control"
                    placeholder="Zdjecie (np. cola.jpg)"
                    required
                >

            </div>

        </div>

        <div class="form-check mb-3">

            <input 
                type="checkbox"
                name="is_promo"
                class="form-check-input"
            >

            <label class="form-check-label">
                Promocja
            </label>

        </div>

        <button 
            class="btn btn-success"
            name="add"
        >
            Dodaj produkt
        </button>

    </form>

</div>

<div class="table-responsive">

<table class="table table-bordered bg-white">

    <thead>

        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Cena</th>
            <th>Stock</th>
            <th>Promo</th>
            <th>Akcje</th>
        </tr>

    </thead>

    <tbody>

    <?php while($product = $result->fetch_assoc()): ?>

        <tr>

            <td><?= $product['id']; ?></td>

            <td><?= $product['name']; ?></td>

            <td>
                <?php
                    $isLogged = isset($_SESSION['user_id']);

                    if($isLogged && $product['promo_price']){

                        echo "
                            <p class='text-decoration-line-through text-muted'>
                                {$product['price']} zł
                            </p>

                            <p class='price text-danger'>
                                {$product['promo_price']} zł
                            </p>
                        ";

                    } else {

                        echo "
                            <p class='price'>
                                {$product['price']} zł
                            </p>
                        ";
                    }
                ?>
            </td>

            <td><?= $product['stock']; ?></td>

            <td>

                <?= $product['is_promo'] ? 'TAK' : 'NIE'; ?>

            </td>

            <td>

                <a 
                    href="?delete=<?= $product['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Usunac produkt?')"
                >
                    Usun
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