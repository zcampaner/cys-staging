<?php
	include ("dbconnection.php");
	$login_name=$_POST['login_name'];
	$sql = "DELETE FROM system.users WHERE login_name =  :login_name";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':login_name', $_POST['login_name']);
	$stmt->execute();

	echo $stmt->rowCount();
?>
