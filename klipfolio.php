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

  // $startDate = isset($_GET['start_date']) ? $_GET['start_date'] :(string) date('Y-m-d');
  // $endDate = isset($_GET['end_date']) ? $_GET['end_date'] :(string) date('Y-m-d');
  // $status = isset($_GET['status']) ? $_GET['status'] : (string) '';


  $startDate = '2016-01-01';
  $endDate = '2016-02-28';
  $status = 5;
  switch($status) {
  case 5:
    echo 'No Show Reported.';
    break;
  case 6:
    echo 'No Show In-Progress.';
    break;
  case 7:
    echo 'No Show Charged';
    break;
  case 8:
    echo 'No Show Invalid';
    break;
   case 9:
    echo 'No Show Failed Charge';
    break;
   case 10:
    echo 'No Show Waived';
    break;
   case 15:
    echo 'No Show Hotel Processed';
    break;
}
  $where = "WHERE t1.created_date::DATE BETWEEN :start_date AND :end_date AND t1.status_name = $status";
  $sorting= "ORDER BY t1.id DESC";

  $db = new PDO("$driver:dbname=$dbname;host=$host;user=$user;password=$pass;");

  $stmt = $db->prepare(
     "SELECT *, AVG(t2.base_rate_total) OVER (PARTITION BY t1.id ORDER BY t1.id DESC) AS average_room_rate 
      FROM gi.t_reservations t1
      INNER JOIN gi.t_reservation_details t2 ON t1.id = t2.reservation_id 
      $where
      $sorting"
  );

  $stmt->bindParam(':start_date', $startDate);
  $stmt->bindParam(':end_date', $endDate);
  $stmt->bindParam(':status', $status);

  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo"<pre>";
  var_dump($result);echo"</pre>";


exit;
    $xmlObj = simplexml_load_string('<ReservationsSummaryReport></ReservationsSummaryReport>');
  
  if (count($result)) {

    $reservation_id = null;
    foreach($result as $key => $row) {

      if ($row['id'] != $reservation_id) {
        $reservation_id = $row['id'];
      
        $reservation = $xmlObj->addChild('Reservation');
        
        $check_in_date = date_create_from_format('Y-m-d', $row['check_in_date']);
        $check_out_date = date_create_from_format('Y-m-d', $row['check_out_date']);
        $reservation_date = new DateTime($row['created_date']);
        $average_booking_window = $check_in_date->diff($reservation_date)->days;

        $los = $check_out_date->diff($check_in_date)->days;
        
        $reservation->addChild('LengthOfStay', $los);
        
        $ratePlan = $reservation->addChild('RatePlan', $row['rate_plan_name']);
        $roomTypes = $reservation->addChild('RoomTypes');
        $roomTypes->addChild('RoomType', $row['room_name']);
        $reservation->addChild('GrossRevenue', $row['total_amount']);
        $reservation->addChild('ReservationDate', $row['created_date']);
        $reservation->addChild('AverageRoomRate', $row['average_room_rate']);
        $reservation->addChild('DWHCommission', $row['dwh_revenue']);
        $reservation->addChild('NetRevenue', $row['total_amount'] - $row['dwh_revenue']);
        $reservation->addChild('AverageBookingWindow', $average_booking_window);

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
