<?php

header('Content-type: text/xml');
date_default_timezone_set('Asia/Manila');

try {
 
  $dbname = DWH_DATABASE_DWHDB_NAME;
  $host = DWH_DATABASE_DWHDB_HOST;
  $user = DWH_DATABASE_DWHDB_USER;
  $pass = DWH_DATABASE_DWHDB_PASSWORD;
  $driver = 'pgsql';

  $startDate = isset($_GET['start_date']) ? $_GET['start_date'] :(string) date('Y-m-d');
  $endDate = isset($_GET['end_date']) ? $_GET['end_date'] :(string) date('Y-m-d');

  $db = new PDO("$driver:dbname=$dbname;host=$host;user=$user;password=$pass;");

  $stmt = $db->prepare(
     'SELECT *, AVG(t2.base_rate_total) OVER (PARTITION BY t1.id ORDER BY t1.id DESC) AS average_room_rate 
      FROM gi.t_reservations t1
      INNER JOIN gi.t_reservation_details t2 ON t1.id = t2.reservation_id 
      WHERE t1.created_date::DATE BETWEEN :start_date AND :end_date
      ORDER BY t1.id DESC'
  );

  $stmt->bindParam(':start_date', $startDate);
  $stmt->bindParam(':end_date', $endDate);
 
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
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
