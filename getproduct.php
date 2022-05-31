<?php 

    include_once'connection.php';

    $id = $_GET["id"];

    $select=$pdo->prepare("select * from product where id=:pid");
    $select->bindParam(":pid",$id);
    $select->execute();

    $row=$select->fetch(PDO::FETCH_ASSOC);

    $response=$row;

    header('Content-Type: application/json');

    echo json_encode($response);




?>