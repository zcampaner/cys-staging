<?php
	include ("dbconnection.php");
    $login_name=$_POST['login_name'];
    $sql = "DELETE FROM system.users WHERE login_name =  :login_name";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login_name', $_POST['login_name']);
    $stmt->execute();

	$chain_code=$_POST['chain_code'];
	$sql = "DELETE FROM system.hotel_chains WHERE chain_code =  :chain_code";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':chain_code', $_POST['chain_code']);
	$stmt->execute();

	echo $stmt->rowCount();
?>
