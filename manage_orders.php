<?php
require "config.php";

// Fetch all orders with user details
$query = "
    SELECT o.id AS order_id, u.user_name, u.user_address, o.invoice_date, o.grand_total
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.invoice_date DESC";
$result = $con->query($query);
?>

<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?> <!-- Include the navigation bar -->
<div class="container pt-5">
    <h1 class="text-center mb-4">Manage Orders</h1>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Invoice Date</th>
                <th>Grand Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['order_id']; ?></td>
                    <td><?= $row['user_name']; ?></td>
                    <td><?= $row['user_address']; ?></td>
                    <td><?= date("d-m-Y", strtotime($row['invoice_date'])); ?></td>
                    <td><?= number_format($row['grand_total'], 2); ?></td>
                    <td>
                        <a href="delete_order.php?id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
