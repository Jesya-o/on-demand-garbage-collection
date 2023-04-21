<?php

require_once('db-connection.php');

function updateClientData($client_id, $name, $surname, $email, $phone)
{
    $link = connectDatabase();
    $query = "UPDATE clients SET name = ?, surname = ?, email = ?, phone_number = ? WHERE client_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ssssi", $name, $surname, $email, $phone, $client_id);
    $updated = $stmt->execute();
    $stmt->close();
    return $updated;
}

function insertOrder($client_id, $name, $surname, $email, $street, $house, $index, $date, $time, $service, $price, $phone, $comment, $selectedItems)
{
    $link = connectDatabase();

    // Update the client's data
    if (!updateClientData($client_id, $name, $surname, $email, $phone)) {
        return false;
    }

    // Insert data into orders table
    $insertOrderQuery = "INSERT INTO orders (client_id, street, house, postcode, date, time_slot, order_type, price, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $orderStmt = $link->prepare($insertOrderQuery);
    $orderStmt->bind_param("ississsds", $client_id, $street, $house, $index, $date, $time, $service, $price, $comment);
    $orderInserted = $orderStmt->execute();

    if ($orderInserted) {
        // Get the order ID
        $orderId = $orderStmt->insert_id;

        // Insert data into bulk_items table if service is 'Bulk Waste Removal'
        if ($service === 'Bulk Waste Removal') {
            $selectedItemsArray = explode('|', $selectedItems);
            foreach ($selectedItemsArray as $item) {
                $item_weight = '';
                switch ($item) {
                    case 'option1':
                        $item_weight = '0-10 kg';
                        break;
                    case 'option2':
                        $item_weight = '11-50 kg';
                        break;
                    case 'option3':
                        $item_weight = '51-100 kg';
                        break;
                    case 'option4':
                        $item_weight = '101-200 kg';
                        break;
                    case 'option5':
                        $item_weight = '201-500 kg';
                        break;
                }
                $insertBulkItemQuery = "INSERT INTO bulk_items (order_id, item_weight) VALUES (?, ?)";
                $bulkStmt = $link->prepare($insertBulkItemQuery);
                $bulkStmt->bind_param("is", $orderId, $item_weight);
                $itemInserted = $bulkStmt->execute();
                
                if (!$itemInserted) {
                    $bulkStmt->close();
                    return false;
                }
            }
            $bulkStmt->close();
        }
    } else {
        $orderStmt->close();
        return false;
    }

    $orderStmt->close();
    return true;
}
?>
