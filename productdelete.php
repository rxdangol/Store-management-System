<?php
	include_once'connection.php';

	$id=$_POST["pid"];

	$sql="delete from product where id=$id";

	$delete=$pdo->prepare($sql);

	if($delete->execute()){

	}else{

		echo "error in deleting";
	}





?>