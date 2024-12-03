<?php
$host = 'mysql';
$dbname = 'idordu';
$db_username = 'du2024';
$db_password = 'du2024';
$conn = new mysqli($host, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
