<?php

$host = "localhost";
$user = "root";  
$pass = "";  
$dbname = "db_resepinaja";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}else{
    echo "Koneksi berhasil!";
}

$sql = "SELECT * FROM resep";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; 
    }
}

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}
echo json_encode($recipes, JSON_PRETTY_PRINT);
?>
