<?php

header('Content-type: text/xml');
//date_default_timezone_set('Asia/Manila');
date_default_timezone_set('UTC');
try {
 
	$dbname = 'dev_dwhdb';
  	$host = '10.1.2.222';
  	$user = 'guest';
  	$pass = 'pass';

  	$driver = 'pgsql';

  	$startDate = isset($_GET['start_date']) ? $_GET['start_date'] :(string) date('Y-m-d');
  	$endDate = isset($_GET['end_date']) ? $_GET['end_date'] :(string) date('Y-m-d');

  	$db = new PDO("$driver:dbname=$dbname;host=$host;user=$user;password=$pass;");
  	$stmt = $db->prepare(
		"SELECT 
			t1.id,
			t1.first_name, 
			t1.last_name, 
			t2.rate_plan_name, 
			t2.room_name,
			t1.check_in_date,
			t1.check_out_date, 
			t1.total_amount,
			t1.created_date,
			t1.dwh_revenue,
			t1.total_amount,
			t3.group_id,
			t1.property_id, 
			t2.no_of_rooms,
			t1.no_of_nights,
			t1.total_no_of_rooms,
			t2.base_rate,
			t2.rate_plan_id,
			t2.room_id,
			t2.reservation_date,
			AVG(t2.base_rate_total) OVER (PARTITION BY t1.id ORDER BY t1.id DESC) AS average_room_rate 
	 	FROM gi.t_reservations t1
	  	INNER JOIN gi.m_status_type t3 ON t1.status_id = t3.id 
	  	INNER JOIN gi.t_reservation_details t2 ON t1.id = t2.reservation_id 
	  	WHERE t1.created_date::DATE BETWEEN :start_date AND :end_date
	  	ORDER BY t1.created_date DESC, t1.id DESC, t2.reservation_id, t2.reservation_date, t2.rate_plan_id, t2.room_id DESC"
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
				$reservation->addAttribute('ID',$row['id']);
				$check_in_date = date_create_from_format('Y-m-d', $row['check_in_date']);
				$check_out_date = date_create_from_format('Y-m-d', $row['check_out_date']);
				$reservation_date = new DateTime($row['created_date']);
				$average_booking_window = $check_in_date->diff($reservation_date)->days;
				
				$los = $check_out_date->diff($check_in_date)->days;
				
				$reservation->addChild('LengthOfStay', $row['no_of_nights']);
				$name = $row['first_name'].' '.$row['last_name'];
				$reservation->addChild('RatePlans');
				
				$ratePlan = $reservation->RatePlans->addChild('RatePlan', $row['rate_plan_name']);
				$ratePlan->addAttribute('ID',$row['rate_plan_id']);
				$ratePlan->addAttribute('totalRoomBaseRate', $row['base_rate']);
				$Roomtype = $ratePlan->addChild('RoomType', $row['room_name']);
				$Roomtype->addAttribute('ID', $row['room_id']);
				$Roomtype->addAttribute('NoOfRooms', $row['no_of_rooms']);
				$Roomtype->addAttribute('BaseRate', $row['base_rate']);
				$Roomtype->addAttribute('Date',date('Y-m-d',strtotime($row['reservation_date'])));
				$reservation->addChild('GrossRevenue', $row['total_amount']);
				$reservation->addChild('ReservationDate',date('Y-m-d H:i A',strtotime($row['created_date'])));
				$reservation->addChild('AverageRoomRate', $row['average_room_rate']);
				$reservation->addChild('DWHCommission', $row['dwh_revenue']);
				$reservation->addChild('NetRevenue', $row['total_amount'] - $row['dwh_revenue']);
				$reservation->addChild('AverageBookingWindow', $average_booking_window);
				$reservation->addChild('Status', $row['group_id']);
				$reservation->addChild('Name', $name);
				$reservation->addChild('HotelID', $row['property_id']); 
				$reservation->addChild('TotalNoOfRooms', $row['total_no_of_rooms']);

			} else {
				
				$ratePlan['totalRoomBaseRate'] += $row['base_rate'];
				$Roomtype = $ratePlan->addChild('RoomType', $row['room_name']);
				$Roomtype->addAttribute('ID', $row['room_id']);
				$Roomtype->addAttribute('NoOfRooms', $row['no_of_rooms']);
				$Roomtype->addAttribute('BaseRate', $row['base_rate']);
				$Roomtype->addAttribute('Date',date('Y-m-d',strtotime($row['reservation_date'])));

			}

		}

  	} 

  	echo $xmlObj->asXML();

} catch(Exception $e) {
 
 	http_response_code(500);

}

?>


