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

$sql = "DELETE FROM products WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

header("Location: products.php");
exit;