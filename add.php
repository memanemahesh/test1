<?php 
    include("config.php");
    //include("login.php")
?>

<html>
<head>
    <title>Admin Panel - Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container pt-5">
    <h1 class="text-center">Add New Product</h1>
    <hr>
    <?php
    if (isset($_POST["submit"])) {
        // Get the form data
        $product_name = $_POST["product_name"];
        $product_rate = $_POST["product_rate"];

        // Validate input
        if (empty($product_name) || empty($product_rate)) {
            echo "<div class='alert alert-danger'>Product Name and Price are required.</div>";
        } else {
            // Insert into the database
            $stmt = $con->prepare("INSERT INTO products (product_name, product_rate) VALUES (?, ?)");
            $stmt->bind_param("sd", $product_name, $product_rate);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Product Added Successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }
    }
    ?>
    <form method="post" action="add.php">
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="product_rate">Product Price</label>
            <input type="number" name="product_rate" id="product_rate" class="form-control" step="0.01" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
</body>
</html>



