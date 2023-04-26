<?php
function connectDatabase() {
    $DB_HOST = 'anysql.itcollege.ee';
    $DB_USER = 'ICS0008_WT_7';
    $DB_PASS = '2f9577c2c776';
    $DB_NAME = 'ICS0008_7';

    $link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if ($link->connect_error) {
        die('Error connecting database: ' . $link->connect_error);
    }

    return $link;
}
