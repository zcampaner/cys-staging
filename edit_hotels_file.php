<?php

include("dbconnection.php");

    if(isset($_POST['hotel_code'])){
        $query = "UPDATE system.hotels SET hotel = :hotel, status = :status, chain_code = :chain_code WHERE hotel_code = :hotel_code";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':hotel_code', $_POST['hotel_code']);
        $stmt->bindParam(':hotel', $_POST['hotel']);
        $stmt->bindParam(':status', $_POST['status']);
        $stmt->bindParam(':chain_code', $_POST['chain_code']);

            $stmt->execute();

        echo $stmt->rowCount();
    }

?>