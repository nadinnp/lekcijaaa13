<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];

    $sql = "INSERT INTO products
            (title, description, price)
            VALUES
            (:title, :description, :price)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":title" => $title,
        ":description" => $description,
        ":price" => $price
    ]);

    header("Location: products.php");
    exit;
}

include "header.php";
?>

<div class="container mt-4">

    <h1>Add Product</h1>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Title
            </label>

            <input
                type="text"
                name="title"
                class="form-control"
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
            ></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Price
            </label>

            <input
                type="number"
                name="price"
                class="form-control"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-primary">
            Add Product
        </button>

        <a
            href="products.php"
            class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

<?php include "footer.php"; ?>