<?php

	include("dbconnection.php");

if (isset($_POST["login_name"])) {

        if (!$_POST['login_name'] || !$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        

                $stmt = $db->prepare("INSERT INTO system.users (login_name,password,first_name,last_name,email,enabled,internal) VALUES (:login_name,:password,:first_name,:last_name,:email,'Yes','Yes')");

                $stmt->bindParam(':login_name', $_POST['login_name']);
                $stmt->bindParam(':first_name', $_POST['first_name']);
                $stmt->bindParam(':last_name', $_POST['last_name']);
                $stmt->bindParam(':password', md5($_POST['password']));
                $stmt->bindParam(':email', $_POST['email']);

                $stmt->execute();
                echo $stmt->rowCount();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        }
}

if (isset($_POST["chain_code"])) {

        if (!$_POST['chain_code'] || !$_POST['chain'] || !$_POST['description']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        

                $stmt = $db->prepare("INSERT INTO system.hotel_chains (chain_code,chain,description,enabled) VALUES (:chain_code,:chain,:description,'Yes')");

                $stmt->bindParam(':chain_code', $_POST['chain_code']);
                $stmt->bindParam(':chain', $_POST['chain']);
                $stmt->bindParam(':description', $_POST['description']);

                $stmt->execute();
                echo $stmt->rowCount();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        }
}

if (isset($_POST["hotel_code"])) {
        if (!$_POST['hotel_code'] || !$_POST['hotel'] || !$_POST['status'] || !$_POST['chain_code']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        

                $stmt = $db->prepare("INSERT INTO system.hotels (hotel_code,hotel,status,chain_code) VALUES (:hotel_code,:hotel,:status,:chain_code)");

                $stmt->bindParam(':hotel_code', $_POST['hotel_code']);
                $stmt->bindParam(':hotel', $_POST['hotel']);
                $stmt->bindParam(':status', $_POST['status']);
                $stmt->bindParam(':chain_code', $_POST['chain_code']);

                $stmt->execute();
                echo $stmt->rowCount();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        }
}

    $db = null;