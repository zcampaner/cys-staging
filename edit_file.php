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
        header("location:index.php");
	}
?>