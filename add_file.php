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

    $db = null;