<?php
function connectDatabase() {
    require_once('db-connection-data.php');

    $link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if ($link->connect_error) {
        die('Error connecting database: ' . $link->connect_error);
    }

    return $link;
}
?>
