<?php

//call the FPDF library
require('fpdf/fpdf.php');

include_once'connection.php';
$id=$_GET['id'];

$select=$pdo->prepare("select * from invoice where invoice_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

//A4 width : 219mm
//default margin : 10m each side
//writable horizontal : 219-(10*2)=199mm

//create pdf object
$pdf = new FPDF('P','mm',array(80,200));

$pdf->AddPage();


$pdf->SetFont('Arial','B',14);
$pdf-> Cell(60,8,'Home Grocery Store',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf-> Cell(60,5,'Jawalakhel, Lalitpur',0,1,'C');
$pdf-> Cell(60,5,'Contact : 01-5544584',0,1,'C');

$pdf->Line(5,28,73,28);


$pdf->Ln(1); // Line Break

$pdf->SetFont('Arial','BI',8);
$pdf-> Cell(12,4,'Bill To :',0,0,'');

$pdf->SetFont('Arial','',8);
$pdf-> Cell(50,4,$row->customer_name,0,1,'L');

$pdf->SetFont('Arial','BI',8);
$pdf-> Cell(18,4,'Invoice no.: ',0,0,'');

$pdf->SetFont('Arial','',8);
$pdf-> Cell(42,4,$row->invoice_id,0,1,'L');

$pdf->SetFont('Arial','BI',8);
$pdf-> Cell(10,4,'Date: ',0,0,'');

$pdf->SetFont('Arial','',8);
$pdf-> Cell(42,4,$row->date,0,1,'L');


//

//Product table

$pdf->SetX(5);
$pdf->SetFont('Courier','B',8);
$pdf-> Cell(38,5,'Product',1,0,'C');
$pdf-> Cell(11,5,'Qty',1,0,'C');
$pdf-> Cell(8,5,'Prc.',1,0,'C');
$pdf-> Cell(11,5,'Total',1,1,'C');

$select=$pdo->prepare("select * from invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
	$pdf->SetX(5);
	$pdf->SetFont('Courier','B',7);
	$pdf-> Cell(38,5,$item->product_name,1,0,'L');
	$pdf-> Cell(11,5,$item->qty,1,0,'C');
	$pdf-> Cell(8,5,$item->price,1,0,'C');
	$pdf-> Cell(11,5,$item->qty*$item->price,1,1,'C');
}

//code

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Subtotal(exc.tax)',1,0,'C');
$pdf-> Cell(20,5,$row->subtotal,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Tax(13%)',1,0,'C');
$pdf-> Cell(20,5,$row->tax,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Discount',1,0,'C');
$pdf-> Cell(20,5,$row->discount,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',8);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Total',1,0,'C');
$pdf-> Cell(20,5,$row->total,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Paid',1,0,'C');
$pdf-> Cell(20,5,$row->paid,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Due',1,0,'C');
$pdf-> Cell(20,5,$row->due,1,1,'C');

$pdf->SetX(8);
$pdf->SetFont('courier','B',6.5);
$pdf-> Cell(20,5,'',0,0,'L');
$pdf-> Cell(25,5,'Payment Type',1,0,'C');
$pdf-> Cell(20,5,$row->payment_method,1,1,'C');

$pdf->SetX(5);
$pdf->SetFont('Courier','B',7);
$pdf-> Cell(27,4,'Important Notice:',0,1,'L');

$pdf->SetX(5);
$pdf->SetFont('Arial','',5);
$pdf-> Cell(75,3,'No item will be replaced or refunded if you dont have the invoice with you.',0,2,'');

$pdf->SetX(5);
$pdf->SetFont('Arial','',5);
$pdf-> Cell(75,3,'You can refund within 2 days of purchase.',0,2,'');


$pdf->Output();

?>