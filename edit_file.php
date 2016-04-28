<?php

include("dbconnection.php");

    if(isset($_POST['login_name'])){
        $query = "UPDATE system.users SET password = :password, first_name = :first_name, last_name = :last_name, email = :email WHERE login_name = :login_name";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':login_name', $_POST['login_name']);
        $stmt->bindParam(':password', md5($_POST['password']));
        $stmt->bindParam(':first_name', $_POST['first_name']);
        $stmt->bindParam(':last_name', $_POST['last_name']);
        $stmt->bindParam(':email', $_POST['email']);

            $stmt->execute();

        echo $stmt->rowCount();
    }
   
    if(isset($_POST['chain_code'])){
        $query = "UPDATE system.hotel_chains SET chain = :chain, description = :description WHERE chain_code = :chain_code";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':chain_code', $_POST['chain_code']);
        $stmt->bindParam(':chain', $_POST['chain']);
        $stmt->bindParam(':description', $_POST['description']);

            $stmt->execute();

        echo $stmt->rowCount();
    }   

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