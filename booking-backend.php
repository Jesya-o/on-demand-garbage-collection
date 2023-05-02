<?php
require_once('session.php');
require_once('db-connection.php');

// Function to update client data in database
function updateClientData($client_id, $name, $surname, $email, $phone, $street, $house, $postcode)
{
    $link = connectDatabase();
    $query = "UPDATE Clients SET name = ?, surname = ?, email = ?, phone_number = ?, street = ?, house = ?, postcode = ? WHERE client_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ssssssii", $name, $surname, $email, $phone, $street, $house, $postcode, $client_id);
    $updated = $stmt->execute();
    $stmt->close();
    return $updated;
}

// Function to update driver schedule according to the driver id, date and time of his work
function updateDriverSchedule($orderId, $date, $timeSlot, $driverId)
{
    $link = connectDatabase();
    $query = "UPDATE driver_schedule SET order_id = ? WHERE date = ? AND time_slot = ? AND driver_id = ?";
    $stmt = $link->prepare($query);
    $updated = $stmt->execute();
    $stmt->close();
    return $updated;
}

// Function to create new order in database
function insertOrder($client_id, $street, $house, $index, $date, $time, $service, $price, $phone, $comment, $selectedItems)
{
    $link = connectDatabase();

    // Insert data into orders table
    $insertOrderQuery = "INSERT INTO Orders (client_id, driver_id, street, house, postcode, date, time_slot, order_type, price, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $orderStmt = $link->prepare($insertOrderQuery);

    // Find the driver and check if the order can be handled, e.g. there is available driver
    $driverId = findDriver($date, $time);
    if ($driverId === null) {
        $orderStmt->close();
        return false; // No available drivers
    }

    $orderStmt->bind_param("iississsds", $client_id, $driverId, $street, $house, $index, $date, $time, $service, $price, $comment);
    $orderInserted = $orderStmt->execute();

    // Update other db if the order is created
    if ($orderInserted) {
        // Get the order ID
        $orderId = $orderStmt->insert_id;

        // Update driver schedule
        updateDriverSchedule($orderId, $date, $time, $driverId);
        // Insert data into bulk_items table if service is 'Bulk Waste Removal'
        if ($service === 'Bulk Waste Removal') {
            $selectedItemsArray = explode('|', $selectedItems);
            $totalWeightLow = 0;
            $totalWeightHigh = 0;
            $numberOfItems = count($selectedItemsArray);

            // Calculate the price
            foreach ($selectedItemsArray as $item) {
                $itemWeightLow = 0;
                $itemWeightHigh = 0;

                switch ($item) {
                    case 'option1':
                        $itemWeightLow = 1;
                        $itemWeightHigh = 20;
                        break;
                    case 'option2':
                        $itemWeightLow = 21;
                        $itemWeightHigh = 50;
                        break;
                    case 'option3':
                        $itemWeightLow = 51;
                        $itemWeightHigh = 100;
                        break;
                    case 'option4':
                        $itemWeightLow = 101;
                        $itemWeightHigh = 200;
                        break;
                    case 'option5':
                        $itemWeightLow = 201;
                        $itemWeightHigh = 500;
                        break;
                }

                $totalWeightLow += $itemWeightLow;
                $totalWeightHigh += $itemWeightHigh;
            }

            $totalWeight = $totalWeightLow . '-' . $totalWeightHigh . ' kg';

            $insertBulkItemQuery = "INSERT INTO Bulk_items (order_id, number_of_items, total_weight) VALUES (?, ?, ?)";
            $bulkStmt = $link->prepare($insertBulkItemQuery);
            $bulkStmt->bind_param("iis", $orderId, $numberOfItems, $totalWeight);
            $itemInserted = $bulkStmt->execute();

            // Handle error
            if (!$itemInserted) {
                $bulkStmt->close();
                return false;
            }
            $bulkStmt->close();
        }
        $orderStmt->close();
        return $orderId;
    } else {
        $orderStmt->close();
        return false;
    }
}

// Function to find the driver based on the needed date and time
function findDriver($date, $time)
{
    $link = connectDatabase();
    $query = "SELECT driver_id FROM driver_schedule WHERE date = ? AND time_slot = ? AND order_id IS NULL";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $availableDrivers = [];

    // Create a list of available drivers
    while ($row = $result->fetch_assoc()) {
        $availableDrivers[] = $row['driver_id'];
    }

    $stmt->close();

    if (count($availableDrivers) > 0) {
        $randomIndex = array_rand($availableDrivers);
        return $availableDrivers[$randomIndex];
    } else {
        return null; // No available drivers
    }
}
