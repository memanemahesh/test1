<?php
require "config.php";

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Delete order items
    $con->query("DELETE FROM order_items WHERE order_id = $order_id");

    // Delete the order
    $con->query("DELETE FROM orders WHERE id = $order_id");

    header("Location: manage_orders.php?status=deleted");
    exit;
}
?>
