<?php
include("includes/db.php");

/* Check DB connection */
if (!$conn) {
    die("DB not connected");
}

/* Admin Data */
$name  = "Admin";
$email = "admin@gmail.com";
$pwd   = password_hash("321", PASSWORD_DEFAULT);

/* Insert Query */
$sql = "INSERT INTO admin (name, email, password, created_at)
        VALUES ('$name', '$email', '$pwd', NOW())";

if (mysqli_query($conn, $sql)) {
    echo "Admin inserted successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
