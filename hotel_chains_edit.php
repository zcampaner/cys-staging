<?php
include("dbconnection.php");

    if(isset($_POST['chain_code'])){

    $ppid = $_POST['chain_code'];

    $sqladd="SELECT chain_code,chain,description FROM system.hotel_chains WHERE chain_code='$ppid'";
	$res=$db->prepare($sqladd);
	$res->execute();
	$result = $res->fetchALL(PDO::FETCH_ASSOC);	

	echo json_encode($result);
}
?>