<?php
require "config.php";

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete product
    $query = $con->prepare("DELETE FROM products WHERE id = ?");
    $query->bind_param("i", $product_id);

    if ($query->execute()) {
        echo "<script>
                alert('Product deleted successfully.');
                window.location.href = 'manage_products.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting product: " . $query->error . "');
                window.location.href = 'manage_products.php';
              </script>";
    }
}
?>
