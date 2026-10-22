<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: products.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM products WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$product = $stmt->fetch();

if (!$product) {
    header("Location: products.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];

    $sql = "UPDATE products
            SET title = :title,
                description = :description,
                price = :price
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":title" => $title,
        ":description" => $description,
        ":price" => $price,
        ":id" => $id
    ]);

    header("Location: products.php");
    exit;
}

include "header.php";
?>

<div class="container mt-4">

    <h1>Update Product</h1>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Title
            </label>

            <input
                type="text"
                name="title"
                class="form-control"
                value="<?php echo htmlspecialchars($product["title"]); ?>"
                required
            >

        </div>

        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea
                name="description"
                class="form-control"
                required
            ><?php echo htmlspecialchars($product["description"]); ?></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Price
            </label>

            <input
                type="number"
                name="price"
                class="form-control"
                value="<?php echo $product["price"]; ?>"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-warning">
            Update Product
        </button>

        <a
            href="products.php"
            class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

<?php include "footer.php"; ?>