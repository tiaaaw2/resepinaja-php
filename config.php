<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "db_resepinaja"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["
    status" => "error", "message" => "gagal tersambung " . $conn->connect_error]));
}
?>
