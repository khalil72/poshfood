<?php
include("includes/db.php");
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: category.php?msg=Invalid+category");
    exit;
}

$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: category.php?msg=Category+deleted+successfully");
    exit;
} else {
    header("Location: category.php?msg=Error+deleting+category");
    exit;
}