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
//   $status = 'Confirmed Guaranteed';
//   switch($status) {
//   case 'Pending':
//   	echo 1;
//   case 'Confirmed Guaranteed':
//     echo 2;
//     break;
//   case 'Cancelled Charged':
//     echo 3;
//     break;
//   case 'Modified Cancelled':
//     echo 4;
//     break;
//   case 'No Show Reported':
//     echo 5;
//     break;
//    case 'No Show In-Progress':
//     echo 6;
//     break;
//    case 'No Show Charged':
//     echo 7;
//     break;
//    case 'No Show Invalid':
//     echo 8;
//     break;
//     case 'No Show Failed Charge':
//     echo 9;
//     break;
//     case 'No Show Waived':
//     echo 10;
//     break;
//     case 'Returned to Pending':
//     echo 11;
//     break;
//     case 'Confirmed Not Guaranteed':
//     echo 12;
//     break;
//     case 'Cancelled No Penalty':
//     echo 13;
//     break;
//     case 'Modified Guaranteed':
//     echo 14;
//     break;
//     case 'No Show Hotel Processed':
//     echo 15;
//     break;
//     case 'On Hold':
//     echo 22;
//     break;
//     case 'Cancelled Failed Charge':
//     echo 23;
//     break;
//     case 'Modified Not Guaranteed':
//     echo 24;
//     break;
//     case 'Cancelled Waived':
//     echo 33;
//     break;
//     case 'Modified Refunded':
//     echo 34;
//     break;
//     case 'Cancelled Refunded':
//     echo 43;
//     break;
//     case 'Cancelled Hotel Processed':
//     echo 53;
//     break;
//     case 'Cancelled On Hold':
//     echo 63;
//     break;
// }
  // $where = "WHERE t1.created_date::DATE BETWEEN :start_date AND :end_date AND t1.status_name = $status";
  // $sorting= "ORDER BY t1.id DESC";

  $db = new PDO("$driver:dbname=$dbname;host=$host;user=$user;password=$pass;");

 
  $stmt = $db->prepare("SELECT *, AVG(t2.base_rate_total) OVER (PARTITION BY t1.id ORDER BY t1.id DESC) AS average_room_rate 
      FROM gi.t_reservations t1
      INNER JOIN gi.m_status_type t3 ON t1.status_id = t3.id 
      INNER JOIN gi.t_reservation_details t2 ON t1.id = t2.reservation_id 
      WHERE t1.created_date::DATE BETWEEN :start_date AND :end_date
      ORDER BY t1.id DESC");

  $stmt->bindParam(':start_date', $startDate);
  $stmt->bindParam(':end_date', $endDate);
  $stmt->bindParam(':status', $status);

  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // echo"<pre>";
  // var_dump($result);echo"</pre>";


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
        $name = $row['first_name'].$row['last_name'];
        $ratePlan = $reservation->addChild('RatePlan', $row['rate_plan_name']);
        $roomTypes = $reservation->addChild('RoomTypes');
        $roomTypes->addChild('RoomType', $row['room_name']);
        $reservation->addChild('GrossRevenue', $row['total_amount']);
        $reservation->addChild('ReservationDate', $row['created_date']);
        $reservation->addChild('AverageRoomRate', $row['average_room_rate']);
        $reservation->addChild('DWHCommission', $row['dwh_revenue']);
        $reservation->addChild('NetRevenue', $row['total_amount'] - $row['dwh_revenue']);
        $reservation->addChild('AverageBookingWindow', $average_booking_window);
        $reservation-> addChild('Status', $row['group_id']);
        // $reservation-> addChild('FirstName', $row['first_name']);
        $reservation-> addChild('Name',$name);

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
