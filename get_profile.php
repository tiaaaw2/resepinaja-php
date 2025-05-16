<?php
header("Content-Type: application/json");
require "config.php"; // File koneksi database

// Pastikan metode yang digunakan adalah GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Pastikan ada parameter "id" di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
    exit;
}

$id = intval($_GET['id']); // Pastikan ID adalah angka untuk keamanan

// Ambil data pengguna berdasarkan ID
$sql = "SELECT id, name, username, phonenumber, email, image_url FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $user]);
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
