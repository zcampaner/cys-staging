<?php

include ("dbconnection.php");

if (isset($_POST["hotel_code"])) {
        if (!$_POST['hotel_code'] || !$_POST['hotel'] || !$_POST['status'] || !$_POST['chain_code']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } 

        else {

            try {        

                $stmt = $db->prepare("INSERT INTO system.hotels (hotel_code,hotel,status,chain_code) VALUES (:hotel_code,:hotel,:status,:chain_code)");

                $stmt->bindParam(':hotel_code', $_POST['hotel_code']);
                $stmt->bindParam(':hotel', $_POST['hotel']);
                $stmt->bindParam(':status', $_POST['status']);
                $stmt->bindParam(':chain_code', $_POST['chain_code']);

                $stmt->execute();
                echo $stmt->rowCount();
            } 

                catch (PDOException $e) {
                    echo $e->getMessage();
                }

        }
}

$db = null;