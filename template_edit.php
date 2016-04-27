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

if(isset($_POST['chain_code'])){

    $ppid = $_POST['chain_code'];

    $sqladd="SELECT chain_code,chain,description FROM system.hotel_chains WHERE chain_code='$ppid' limit 1";
	$res=$db->prepare($sqladd);
	$res->execute();
	$result = $res->fetchALL(PDO::FETCH_ASSOC);	

	echo json_encode($result);
}
if(isset($_POST['hotel_code'])){

    $ppid = $_POST['hotel_code'];

    $sqladd="SELECT hotel_code,hotel,status,chain_code FROM system.hotels WHERE hotel_code='$ppid' limit 1";
    $res=$db->prepare($sqladd);
    $res->execute();
    $result = $res->fetchALL(PDO::FETCH_ASSOC); 

    echo json_encode($result);
}
?>