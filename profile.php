<?php

session_start();

require_once "config.php";

// Provjera sesije
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// ID korisnika
$id = $_GET["id"] ?? $_SESSION["user_id"] ?? null;

if (!$id) {
    die("User ID is missing!");
}

// Pronalazimo korisnika iz baze
$sql = "SELECT * FROM users WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->bindParam(":id", $id, PDO::PARAM_INT);

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
</head>

<body class="bg-light">

<\div class="container mt-5">

  <\div class="card shadow p-4">

    <h2>Edit Profile</h2>

    <hr>

    <form action="update.php" method="POST">

      <input
        type="hidden"
        name="id"
        value="<?= $user['id'] ?>"
      >

      <div class="mb-3">
        <label>Username</label>

        <input
          type="text"
          name="username"
          class="form-control"
          value="<?= htmlspecialchars($user['username']) ?>"
          required
        >
      </div>

      <\div class="mb-3">
        <label>Name</label>

        <input
          type="text"
          name="name"
          class="form-control"
          value="<?= htmlspecialchars($user['name']) ?>"
          required
        >
      </div>

      <div class="mb-3">
        <label>Surname</label>

        <input
          type="text"
          name="surname"
          class="form-control"
          value="<?= htmlspecialchars($user['surname']) ?>"
          required
        >
      </div>

      <\div class="mb-3">
        <label>Email</label>

        <input
          type="email"
          name="email"
          class="form-control"
          value="<?= htmlspecialchars($user['email']) ?>"
          required
        >
      </div>

      <button
        type="submit"
        name="update"
        class="btn btn-success"
      >
        Save Changes
      </button>

      <a
        href="dashboard.php"
        class="btn btn-secondary"
      >
        Back
      </a>

    </form>

  </div>

</div>

</body>
</html>