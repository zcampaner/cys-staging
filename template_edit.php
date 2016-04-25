<?php
include("dbconnection.php");

    if(isset($_POST['login_name'])){

    $ppid = $_POST['login_name'];

    $sqladd="SELECT login_name,first_name,last_name,email FROM system.users WHERE login_name='$ppid' limit 1";
	$res=$db->prepare($sqladd);
	$res->execute();
	$result = $res->fetchALL(PDO::FETCH_ASSOC);	

	echo json_encode($result);
}
?>