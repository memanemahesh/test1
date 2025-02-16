<?php require "config.php"; ?>
<html>
<head>
		<title>invoice</title>
		

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
		<script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
		<style>
		body {
  background-color:#F0F8FF ;
		}
  .text-success {
    color:red; 
}
 

</style>
	</head>
<body>
<div class='container pt-5'>
    <h1 style="text-align:right;"><a href="dashbord.php">Admin</a></h1><hr>
    <?php
    if (isset($_POST["submit"])) {
        $stmt = $con->prepare("INSERT INTO users (INVOICE_DATE, user_name, user_address, GRAND_TOTAL, user_no) VALUES (?, ?, ?, ?, ?)");
        
        $invoice_date = date("Y-m-d", strtotime($_POST["invoice_date"]));
        $stmt->bind_param("ssssd", $invoice_date, $_POST["cname"], $_POST["caddress"], $_POST["grand_total"], $_POST["cno"]);
        
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            $order_stmt = $con->prepare("INSERT INTO orders (user_id, invoice_date, grand_total) VALUES (?, ?, ?)");
            $order_stmt->bind_param("isd", $user_id, $invoice_date, $_POST["grand_total"]);
            $order_stmt->execute();
            $order_id = $order_stmt->insert_id;

            $item_stmt = $con->prepare("INSERT INTO order_items (order_id, product_id, quantity, total) VALUES (?, ?, ?, ?)");
            for ($i = 0; $i < count($_POST["pname"]); $i++) {
                if (empty($_POST["pname"][$i]) || empty($_POST["qty"][$i]) || empty($_POST["total"][$i])) {
                    continue; 
                }
                $product_id = $_POST["pname"][$i];
                $quantity = $_POST["qty"][$i];
                $total = $_POST["total"][$i];
                $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $total);
                $item_stmt->execute();
            }

            echo "<div class='alert alert-success'>Invoice Added. <a href='print.php?id={$order_id}' target='_BLANK'>Click</a> here to Print Invoice</div>";
        } else {
            echo "<div class='alert alert-danger'>Invoice Added Failed. Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
    ?>
    <form method='post' action='index.php' autocomplete='off'>
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'><b>Invoice Details</b></h5>
                <div class='form-group'>
                    <label>Invoice Date</label>
                    <input type='text' name='invoice_date' id='date' required class='form-control' >
                </div>
            </div>
            <div class='col-md-8'>
                <h5 class='text-success'><b>Customer Details</b></h5>
                <div class='form-group'>
                    <label>Name</label>
                    <input type='text' name='cname'  minlength="2" maxlength="25" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Phone No</label>
                    <input type='number' name='cno' pattern="\d{10}" minlength="10" maxlength="10" required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Address</label>
                    <input type='text' name='caddress' required class='form-control'>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <h5 class='text-success'><b>Product Details</b></h5>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='product_tbody'>
                        <tr>
                            <td>
                                <select name='pname[]' class='form-control product-select' required>
                                    <option value="" selected hidden>Select product</option>
                                    <?php
                                    $result = $con->query("SELECT id, product_name, product_rate FROM products");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}' data-price='{$row['product_rate']}'>{$row['product_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type='text' required name='price[]' class='form-control price' readonly></td>
                            <td><input type='text' required name='qty[]' class='form-control qty'></td>
                            <td><input type='text' required name='total[]' class='form-control total' readonly></td>
                            <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'></td>
                            <td colspan='2' class='text-right'>Total</td>
                            <td><input type='text' name='grand_total' id='grand_total' class='form-control' required readonly></td>
                        </tr>
                    </tfoot>
                </table>
                <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
            </div>
        </div>
    </form>
</div>
<script>

$(document).ready(function(){
    $("#date").datepicker({
        dateFormat: "dd-mm-yy"
    });
});
    $(document).ready(function () {
        $("#btn-add-row").click(function () {
            var row = $("#product_tbody tr:first").clone();
            row.find("input").val("");
            $("#product_tbody").append(row);
        });

        $("body").on("click", ".btn-row-remove", function () {
            if (confirm("Are you sure?")) {
                $(this).closest("tr").remove();
                updateGrandTotal();
            }
        });

        $("body").on("change", ".product-select", function () {
            var price = $(this).find(":selected").data("price");
            var row = $(this).closest("tr");
            row.find(".price").val(price);
            updateRowTotal(row);
        });

        $("body").on("keyup change", ".qty", function () {
            var row = $(this).closest("tr");
            updateRowTotal(row);
        });

        function updateRowTotal(row) {
            var price = parseFloat(row.find(".price").val()) || 0;
            var qty = parseInt(row.find(".qty").val()) || 0;
            row.find(".total").val(price * qty);
            updateGrandTotal();
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $(".total").each(function () {
                grandTotal += parseFloat($(this).val()) || 0;
            });
            $("#grand_total").val(grandTotal);
        }
    });
</script>
</body>
</html>
