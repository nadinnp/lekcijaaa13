<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$search = $_GET["search"] ?? "";

if ($search != "") {

    $sql = "SELECT * FROM products
            WHERE title LIKE :search
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":search" => "%" . $search . "%"
    ]);

} else {

    $sql = "SELECT * FROM products ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$products = $stmt->fetchAll();

include "header.php";
?>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">
            Digital School
        </a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="logout.php">
                Sign out
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">

    <h1>Products Dashboard</h1>

    <a href="create_product.php"
       class="btn btn-primary mb-3">
        Add Product
    </a>

    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search product by title"
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button
                type="submit"
                class="btn btn-dark">
                Search
            </button>

        </div>

    </form>

    <table class="table table-bordered">

        <thead>

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

        </thead>

        <tbody>

        <?php foreach ($products as $product): ?>

            <tr>

                <td>
                    <?php echo $product["id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($product["title"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($product["description"]); ?>
                </td>

                <td>
                    <?php echo $product["price"]; ?>
                </td>

                <td>

                    <a
                        href="update_product.php?id=<?php echo $product["id"]; ?>"
                        class="btn btn-warning btn-sm">
                        Update
                    </a>

                    <a
                        href="delete_product.php?id=<?php echo $product["id"]; ?>"
                        class="btn btn-danger btn-sm">
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

    <a href="dashboard.php"
       class="btn btn-secondary">
        Back to Dashboard
    </a>

</div>

<?php include "footer.php"; ?>