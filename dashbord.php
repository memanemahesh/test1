

<?php
 

$user = 'root';
$password = '';
 

$database = 'bill';
 

$servername='localhost:3306';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 

if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
 

$sql = " SELECT * FROM users ORDER BY id DESC ";
$result = $mysqli->query($sql);
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title>user list</title>
 
    <style>
    
    
	    body {
             background-color:#F0FFFF ;
		 }
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }
 
        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }
 
        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }
 
        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
 
        td {
            font-weight: lighter;
        }
    
    </style>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
 
<body>
    <section>

   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashbord.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_products.php">Manage Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Manage_orders.php">Manage Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashbord.php">Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Index</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container pt-5">
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



                <!-- <h1 style=text-align ="center"> <a href="index.php">Create New Bill</a><h1>             <a href="add.php">Add products</a></h1></h1> -->
                <!-- <h1 style="text-align:right;"><a href="add.php">Add products</a></h1><hr> -->

        <h2 style = "text-align:center">users</h1><br>       
       
        <table>
            <tr>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>User Name</th>
                <th>User No</th>
                <th>User Address</th>
                <th>Grand Total in Rs</th>
                
    <th colspan="2">Actions</th>
  </tr>
  <tr>
   
  </tr>
  <tr>
    

                
            </tr>
           
            <?php
               
                while($rows=$result->fetch_assoc())
                {
            ?>
            <tr>
       
                <td><?php echo $rows['id'];?></td>
                <td><?php echo $rows['INVOICE_DATE'];?></td>
                <td><?php echo $rows['user_name'];?></td>
                <td><?php echo $rows['user_no'];?></td> 
                <td><?php echo $rows['user_address'];?></td>
                <td><?php echo $rows['GRAND_TOTAL'];?></td> 

                
              
                <td><a href="deleat_user.php?id=<?php echo $rows['id']; ?>">Delete</a></td>
                <td><a href="print.php?id=<?php echo $rows['id']; ?>">Print</a></td>
              
            </tr>
            <?php
                }
            ?>
        </table>
    </section
</body>
 
</html>