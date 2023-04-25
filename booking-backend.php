<?php
require_once('session.php');
require_once('db-connection.php');

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

function updateDriverSchedule($order_id, $date, $time_slot, $driver_id) {
    $link = connectDatabase();
    $query = "UPDATE driver_schedule SET order_id = ? WHERE date = ? AND time_slot = ? AND driver_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("isii", $order_id, $date, $time_slot, $driver_id);
    $updated = $stmt->execute();
    $stmt->close();
    return $updated;
}

function insertOrder($client_id, $street, $house, $index, $date, $time, $service, $price, $phone, $comment, $selectedItems)
{
    $link = connectDatabase();

    // Insert data into orders table
    $insertOrderQuery = "INSERT INTO Orders (client_id, driver_id, street, house, postcode, date, time_slot, order_type, price, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $orderStmt = $link->prepare($insertOrderQuery);

    $driver_id = assignDriver($date, $time);
    if ($driver_id === null) {
        $orderStmt->close();
        return false; // No available drivers
    }

    $orderStmt->bind_param("iississsds", $client_id, $driver_id, $street, $house, $index, $date, $time, $service, $price, $comment);
    $orderInserted = $orderStmt->execute();
    if ($orderInserted) {
        // Get the order ID
        $orderId = $orderStmt->insert_id;
        updateDriverSchedule($orderId, $date, $time, $driver_id);
        // Insert data into bulk_items table if service is 'Bulk Waste Removal'
        if ($service === 'Bulk Waste Removal') {
            $selectedItemsArray = explode('|', $selectedItems);
            $totalWeightLow = 0;
            $totalWeightHigh = 0;
            $numberOfItems = count($selectedItemsArray);

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

function assignDriver($date, $time) {
    $link = connectDatabase();
    $query = "SELECT driver_id FROM driver_schedule WHERE date = ? AND time_slot = ? AND order_id IS NULL";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $availableDrivers = [];
    
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
