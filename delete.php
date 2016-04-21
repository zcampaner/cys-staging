<?php
	include ("dbconnection.php");
	$pid=$_GET['delete_user'];
	// var_dump($pid);die;
	// $sql="DELETE FROM system.users where login_name=$pid";
	// $qry=$db->prepare($sql);
	// $qry->execute(array($pid));
	$sql = "DELETE FROM system.users WHERE login_name =  :delete_user";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':delete_user', $pid, PDO::PARAM_INT);   
	$stmt->execute();
		echo "<script language='javascript' type='text/javascript'>alert('Successfully Deleted!')</script>";
		echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";
?>
