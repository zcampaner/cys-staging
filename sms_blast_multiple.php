<?php

		$host  = "localhost";
		$user = "root";  
	    $pass = "G1vepizza";
		$dbase = "wf_workflow";
	 	$mysqli = mysqli_connect($host,$user,$pass,$dbase) or die (mysqli_error());
include('class.pmFunctions.php');
$file = fopen('/var/www/html/emailblast/details.csv', 'r');
$data = array();
$i = 0;
while (($line = fgetcsv($file)) !== FALSE) {
if($i != 0) {
$data[$i] = array(
'mobile_numer' => $line[0],
'customer_name' => $line[1],
'link' => $line[2],
'rate' => $line[3],
'type' => $line[4]
);

$type = $data[$i]['type'];
$query = "SELECT * FROM `sms_template` WHERE template_name = '$type'";
$template = mysqli_fetch_assoc(mysqli_query($mysqli,$query));

  $field_names = array('<Customer Name>', '<Rate>', '<Link>');
$customer_data = array($data[$i]['customer_name'], $data[$i]['rate'], $data[$i]['link']);
//var_dump($customer_data);die;
$sms_message = str_replace($field_names, $customer_data, $template['body']);
echo $sms_message. "<br>";

 //DKFSendSMS_doSend($data[$i]['mobile_numer'], $sms_message);

}
$i++;
}
fclose($file);

?>