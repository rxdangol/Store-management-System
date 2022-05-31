<?php
	include_once'connection.php';

	$id=$_POST["pid"];


	$sql="delete invoice , invoice_details FROM invoice INNER JOIN invoice_details ON invoice.invoice_id = invoice_details.invoice_id where invoice.invoice_id=$id";

	$delete=$pdo->prepare($sql);

	if($delete->execute()){

	}else{

		echo "Error in deleting";
	}





?>