<?php

session_start();

require_once "config.php";

// Provjera da li je korisnik prijavljen
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Preuzimanje svih korisnika iz baze
$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .main-content {
            padding: 30px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">

    <span class="navbar-brand">
      Welcome,
      <?= htmlspecialchars($_SESSION["username"]) ?>
    </span>

    <a href="logout.php"
       class="btn btn-outline-light">
      Sign out
    </a>

  </div>
</nav>

<\div class="container-fluid">
  <\div class="row">

    <!-- SIDEBAR -->
    <\div class="col-md-2 sidebar">

      <h5 class="mt-4 ms-3">Menu</h5>

      <a href="dashboard.php">
        Dashboard
      </a>

      <a href="profile.php">
        Edit Profile
      </a>

    </div>

    <!-- MAIN CONTENT -->
    <\div class="col-md-10 main-content">

      <h2>Dashboard</h2>

      <hr>

      <h4>All Registered Users</h4>

      <table class="table table-striped table-bordered">

        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>

          <?php foreach ($users as $user): ?>

            <tr>
              <td><?= $user["id"] ?></td>

              <td>
                <?= htmlspecialchars($user["username"]) ?>
              </td>

              <td>
                <?= htmlspecialchars($user["name"]) ?>
              </td>

              <td>
                <?= htmlspecialchars($user["surname"]) ?>
              </td>

              <td>
                <?= htmlspecialchars($user["email"]) ?>
              </td>

              <td>
                <a
                  href="profile.php?id=<?= $user['id'] ?>"
                  class="btn btn-primary btn-sm"
                >
                  Update
                </a>

                <form
                  action="delete.php"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Are you sure?');"
                >

                  <input
                    type="hidden"
                    name="id"
                    value="<?= $user['id'] ?>"
                  >

                  <button
                    type="submit"
                    class="btn btn-danger btn-sm"
                  >
                    Delete
                  </button>

                </form>

              </td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>

    </div>
  </div>
</div>

</body>
</html>