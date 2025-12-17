<?php
include("includes/db.php");
session_start();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: product.php?msg=" . urlencode("Invalid product"));
    exit;
}

$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Delete image file if exists
    if (!empty($row['image'])) {
        $path = __DIR__ . "/uploads/products/" . $row['image'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    
    // Delete product from database
    $del = $conn->prepare("DELETE FROM products WHERE id = ?");
    $del->bind_param("i", $id);
    if ($del->execute()) {
        header("Location: product.php?msg=" . urlencode("Product deleted successfully"));
    } else {
        header("Location: product.php?msg=" . urlencode("Error deleting product: " . $conn->error));
    }
} else {
    header("Location: product.php?msg=" . urlencode("Product not found"));
}
exit;