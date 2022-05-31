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
$pdf = new FPDF('P','mm','A4');

// String oreintation (P or L) - Portrait or landscape
// String unit(pt,mm,cm and in) - measure unit
// Mixed format (A3, A4, A5, Letter and Legal)- format of pages

//add new page

$pdf->AddPage();
// $pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial','B',16);
$pdf-> Cell(80,8,'Home Grocery Store',0,0,'');

$pdf->SetFont('Arial','B',13);
$pdf-> Cell(112,8,'Invoice',0,1,'R');

$pdf->SetFont('Arial','',12);
$pdf-> Cell(80,5,'Jawalakhel, Lalitpur',0,0,'');

$pdf->SetFont('Arial','',12);
$pdf-> Cell(112,5,'Invoice ID : '.$row->invoice_id,0,1,'R');

$pdf->SetFont('Arial','',12);
$pdf-> Cell(80,5,'Contact : 01-5544584',0,0,'');

$pdf->SetFont('Arial','',12);
$pdf-> Cell(112,5,'Date : '.$row->date,0,1,'R');

//line(x1,y1,x2,y2);

$pdf->Line(5,30,205,30);
$pdf->Line(5,31,205,31);

$pdf->Ln(10); // Line Break

$pdf->SetFont('Arial','BI',12);
$pdf-> Cell(20,10,'Bill To:',0,0,'');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(50,10,$row->customer_name,0,1,'');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,'Product',1,0,'C');
$pdf-> Cell(20,8,'Qty',1,0,'C');
$pdf-> Cell(30,8,'Price',1,0,'C');
$pdf-> Cell(40,8,'Total',1,1,'C');

$select=$pdo->prepare("select * from invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
	$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,$item->product_name,1,0,'L');
$pdf-> Cell(20,8,$item->qty,1,0,'C');
$pdf-> Cell(30,8,$item->price,1,0,'C');
$pdf-> Cell(40,8,$item->qty*$item->price,1,1,'C');
}

$pdf->SetFont('Arial','B',10);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Subtota(exc.tax)',1,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf-> Cell(40,8,$row->subtotal,1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Tax',1,0,'C');
$pdf-> Cell(40,8,$row->tax,1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Discount',1,0,'C');
$pdf-> Cell(40,8,$row->discount,1,1,'C');

$pdf->SetFont('Arial','B',14);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Total',1,0,'C');
$pdf-> Cell(40,8,$row->total,1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Paid',1,0,'C');
$pdf-> Cell(40,8,$row->paid,1,1,'C');
 
$pdf->SetFont('Arial','B',14);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Due',1,0,'C');
$pdf-> Cell(40,8,$row->due,1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(100,8,'',0,0,'L');
$pdf-> Cell(20,8,'',0,0,'C');
$pdf-> Cell(30,8,'Payment Type',1,0,'C');
$pdf-> Cell(40,8,$row->payment_method,1,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf-> Cell(36,10,'Important Notice:',0,0,'L');

$pdf->SetFont('Arial','',8);
$pdf-> Cell(150,10,'No item will be replaced or refunded if you dont have the invoice with you. you can refund within 2 days of purchase.',0,0,'C');

//output the result
$pdf->Output();

?>