<?php

// header('Content-type: text/xml');
// date_default_timezone_set('Asia/Manila');

try {
 
  // $dbname = DWH_DATABASE_DWHDB_NAME;
  // $host = DWH_DATABASE_DWHDB_HOST;
  // $user = DWH_DATABASE_DWHDB_USER;
  // $pass = DWH_DATABASE_DWHDB_PASSWORD;

  $dbname = 'dev_dwhdb';
  $host = '10.1.2.222';
  $user = 'guest';
  $pass = 'pass';
  $driver = 'pgsql';


  $db = new PDO("$driver:dbname=$dbname;host=$host;user=$user;password=$pass;");

 
  $stmt = $db->prepare("SELECT DISTINCT id,org_name
  	FROM core.m_organizations");


  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // echo"<pre>";
  // var_dump($result);echo"</pre>";
  // die;

    $xmlObj = simplexml_load_string('<HotelsSummaryList></HotelsSummaryList>');
  
  if (count($result)) {

    $hotel_id = null;
    foreach($result as $key => $row) {

      if ($row['id'] != $hotel_id) {
        $hotel_id = $row['id'];
      
        $hotels = $xmlObj->addChild('Hotels');
        
        $hotels-> addChild('HotelID', $row['id']);
        $hotels-> addChild('HotelName', $row['org_name']);

      } else {

        $roomTypes->addChild('RoomType', $row['room_name']);

      }

    }

  }

  echo $xmlObj->asXML();

} catch(Exception $e) {
  echo $e->getMessage();
//  http_response_code(500);

}




?>

