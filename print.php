<?php
require("fpdf/fpdf.php");
require "config.php";
require ("word.php");



if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("No invoice ID provided.");
}


$info = [
    "customer" => "",
    "address" => "",
    "no" => "",
    "invoice_no" => "",
    "invoice_date" => "",
    "total_amt" => "",
    "words"=>"",
];

$sql = "SELECT * FROM users WHERE id='{$_GET["id"]}'";
$res = $con->query($sql);

if (!$res) {
    die("SQL Error: " . $con->error);
}

if($res->num_rows > 0){
    $row = $res->fetch_assoc();
    $info["customer"] = $row["user_name"];
    $info["address"] = $row["user_address"];
    $info["no"] = $row["user_no"];
    $info["invoice_no"] = $row["id"];
    $info["invoice_date"] = date("d-m-Y", strtotime($row["INVOICE_DATE"]));
    $info["total_amt"] = $row["GRAND_TOTAL"];
} else {
    die("No invoice found with the provided ID.");
}

$order_items_sql = "SELECT oi.quantity, p.product_name, p.product_rate FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = '{$_GET["id"]}'";
$order_items_res = $con->query($order_items_sql);


$pdf = new FPDF();
$pdf->AddPage();
   
        $pdf->SetFont('Arial','B',18);
        $pdf->SetY(15);
        $pdf->SetX(80);
        $pdf->Cell(50,10," Online Billing Softwere ",0,1,"R");
        $pdf->SetFont('Arial','B',18);
        
        $pdf->SetY(25);
        $pdf->SetX(60);
        $pdf->Cell(50,10," Pune 410006",0,1,"R");
        $pdf->SetFont('Arial','B',12);
        
        $pdf->Line(0,40,400,40);


      $pdf->SetY(45);
      $pdf->SetX(10);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(40,10,"Bill To: ",0,1);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(50,7,"Name : ".$info["customer"],0,1);
      $pdf->Cell(50,7,"Phone No : ".$info["no"],0,1);
      $pdf->Cell(50,7,"Address: ".$info["address"],0,1);
      
      $pdf->SetY(55);
      $pdf->SetX(-60);
      $pdf->Cell(50,7,"Invoice Number : ".$info["invoice_no"]);
      
      $pdf->SetY(63);
      $pdf->SetX(-60);
      $pdf->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);

$pdf->Line(0,80,400,80);
$pdf->SetY(90);
$pdf->SetX(10);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(60, 10, "Product Name", 1);
$pdf->Cell(30, 10, "Quantity", 1);
$pdf->Cell(30, 10, "Price", 1);
$pdf->Cell(40, 10, "Total", 1);
$pdf->Ln();
$pdf->SetFont("Arial", "", 12);

$grand_total = 0; 

while ($item = $order_items_res->fetch_assoc()) {
    $quantity = $item["quantity"];
    $price = $item["product_rate"];
    $total = $quantity * $price;
    $grand_total += $total; // Add to grand total

    $pdf->Cell(60, 10, $item["product_name"], 1);
    $pdf->Cell(30, 10, $quantity, 1,0,"C");
    $pdf->Cell(30, 10, number_format($price, 2), 1, 0, ); // Display product price
    $pdf->Cell(40, 10, number_format($total, 2), 1,0,"C"); // Display item total
    $pdf->Ln();
}

// Display the grand total
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(60, 10, "Grand Total", 1);
$pdf->Cell(30, 10, "", 1); // Empty cell for Quantity
$pdf->Cell(30, 10, "", 1); // Empty cell for Price
$pdf->Cell(40, 10, number_format($grand_total, 2), 1, 1, "C"); // Display grand total

// $pdf->SetY(-50);
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(0,10,"",0,1,"R");
// $pdf->SetY(225);
// $pdf->SetX(10);
// $pdf->SetFont('Arial','B',12);
// $pdf->Cell(0,9,"Amount in Words ",0,1);
// $pdf->SetFont('Arial','',12);
// $pdf->Cell(0,9,$info["words"],0,1,);


$pdf->Ln(15);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Owner's Signature",0,1,"R");
$pdf->SetFont('Arial','',10);


$pdf->Output();
?>
