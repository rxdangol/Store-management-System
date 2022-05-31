<?php

		try{

			$pdo = new PDO("mysql:host=localhost;dbname=pos", "root", "");

			// echo "connection succesful.";

		}catch(PDOException $f){

			echo $f->getmessage();

		}
		

	
?>