<?php
# pdo options/attributes
    $opt = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
    # data source name
	include("dbconnection.php");

if (isset($_POST["frmSubmit"])) {

        if (!$_POST['login_name'] || !$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        
            	$password = md5($_POST['password']);
                $db = new PDO($dsn, $user, $pass, $opt);
                $stmt = $db->prepare("INSERT INTO system.users (login_name,password,first_name,last_name,email,enabled,internal) VALUES (:login_name,:password,:first_name,:last_name,:email,'Yes','Yes')");

<<<<<<< HEAD
                $STH->bindParam(':login_name', $_POST['login_name']);
                $STH->bindParam(':first_name', $_POST['first_name']);
                $STH->bindParam(':last_name', $_POST['last_name']);
                $STH->bindParam(':password', $password);
                $STH->bindParam(':email', $_POST['email']);
=======
                $stmt->bindParam(':login_name', $_POST['login_name']);
                $stmt->bindParam(':first_name', $_POST['first_name']);
                $stmt->bindParam(':last_name', $_POST['last_name']);
                $stmt->bindParam(':password', $_POST['password']);
                $stmt->bindParam(':email', $_POST['email']);
>>>>>>> 180738ba41c17f445d03e663342de4407f7b0287

                $stmt->execute();

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        }
}

    $db = null;