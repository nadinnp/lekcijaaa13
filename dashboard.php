<?php

require_once "config.php";

// Provjera da li je korisnik prijavljen
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars(
    $_SESSION["username"],
    ENT_QUOTES,
    "UTF-8"
);

$name = htmlspecialchars(
    $_SESSION["name"],
    ENT_QUOTES,
    "UTF-8"
);

include "header.php";
?>

<!-- Navigacija -->
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

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidebar p-0">

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        </nav>

        <!-- Glavni sadrzaj -->
        <main class="col-md-9 col-lg-10 dashboard-content">

            <h1>Dashboard</h1>

            <p>
                Welcome,
                <strong><?php echo $name; ?></strong>!
            </p>

            <div class="card mt-4">
                <div class="card-body">

                    <h5 class="card-title">
                        User Information
                    </h5>

                    <p>
                        Username:
                        <?php echo $username; ?>
                    </p>

                    <p>
                        You are successfully logged in!
                    </p>

                    <a href="logout.php"
                       class="btn btn-danger">
                        Log out
                    </a>

                </div>
            </div>

        </main>

    </div>
</div>

<?php include "footer.php"; ?>