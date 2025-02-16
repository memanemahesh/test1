<?php require "config.php"; ?>
<html>
<head>
    <title>Admin Panel - View Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container pt-5">
    <h1 class="text-center">Product List</h1>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $con->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['product_rate']}</td>
                        <td>
                            <a href='edit_product.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
