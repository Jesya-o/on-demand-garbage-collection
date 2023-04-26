<?php
require_once('../db-connection.php');
require_once('../token-management.php');

function getAvailableTimeSlots($date) {
    $link = connectDatabase();
    $query = "SELECT DISTINCT time_slot FROM driver_schedule WHERE date = ? AND order_id IS NULL";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $availableTimeSlots = [];

    while ($row = $result->fetch_assoc()) {
        $availableTimeSlots[] = $row['time_slot'];
    }

    $stmt->close();
    return $availableTimeSlots;
}


if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $timestamp = strtotime($date);
	$current_date = strtotime(date('Y-m-d'));
	$date = date('Y-m-d', $timestamp);

    $availableTimeSlots = getAvailableTimeSlots($date);
    
    // Save the result to a JSON file
    $jsonData = json_encode($availableTimeSlots);
    
    // Output the result
    echo $jsonData;
}
