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

function insertOrder($client_id, $street, $house, $index, $date, $time, $service, $price, $phone, $comment, $selectedItems)
{
    $link = connectDatabase();

    // Insert data into orders table
    $insertOrderQuery = "INSERT INTO Orders (client_id, driver_id, street, house, postcode, date, time_slot, order_type, price, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $orderStmt = $link->prepare($insertOrderQuery);

    $driver_id = assignDriver($date, $time); // You can assign a driver ID here
    $orderStmt->bind_param("iississsds", $client_id, $driver_id, $street, $house, intval($index), $date, $time, $service, $price, $comment);
    $orderInserted = $orderStmt->execute();

    if ($orderInserted) {
        // Get the order ID
        $orderId = $orderStmt->insert_id;
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
                        $itemWeightLow = 10;
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
    return 1;
}
