<?php
function deleteTokenByClientId($clientId)
{
    $link = connectDatabase();
    $query = "DELETE FROM Sessions WHERE client_id = ?";
    $statement = $link->prepare($query);
    $statement->bind_param('i', $clientId);
    if ($statement->execute()) {
        $statement->close();
        return true;
    }
}

function getTokenByClientId($clientId)
{
    $link = connectDatabase();
    $query = "SELECT token FROM Sessions WHERE client_id = ?";
    $statement = $link->prepare($query);
    $statement->bind_param('i', $clientId);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc()['token'];
    $statement->close();
    return $result;
}

function authenticateUser($username, $password)
{
    $link = connectDatabase();
    $query = "SELECT client_id, password FROM Clients WHERE username = ?";
    $statement = $link->prepare($query);
    $statement->bind_param('s', $username);
    $statement->execute();
    $data = $statement->get_result()->fetch_assoc();
    $statement->close();

    if (password_verify($password, $data['password'])) {

        $clientId = $data['client_id'];
        deleteTokenByClientId($clientId);

        $query = "INSERT INTO Sessions (token, client_id, ip) VALUES (?, ?, ?)";
        $statement = $link->prepare($query);
        $statement->bind_param(
            'sis',
            uniqid($clientId, true),
            $clientId,
            $_SERVER['REMOTE_ADDR']
        );
        $statement->execute();
        $statement->close();

        return base64_encode($clientId . ":" . getTokenByClientId($clientId));
    }

    return false;
}

$clientKeyValid = null;
function validateClientKey($clientKey)
{
    global $clientKeyValid;
    if ($clientKeyValid === null) {
        // decode clientKey
        list($clientId, $token) = explode(':', base64_decode($clientKey));
        // select by client_id, token, ip
        $link = connectDatabase();
        $query = "SELECT client_id, token, ip FROM Sessions WHERE client_id = ? AND token = ? AND ip = ?";
        $statement = $link->prepare($query);
        $statement->bind_param(
            'iss',
            $clientId,
            $token,
            $_SERVER['REMOTE_ADDR']
        );

        $statement->execute();
        $result = false;
        if ($statement->get_result()->num_rows > 0) {
            $result = true;
        }
        $statement->close();
        $clientKeyValid = $result;
    }
    return $clientKeyValid;
}

function getClientId() {
    return explode(':', base64_decode($_SESSION['client_key']))[0];
}
