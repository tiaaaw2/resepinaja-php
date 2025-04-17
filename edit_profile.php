<?php
header("Content-Type: application/json");
require "config.php"; // File koneksi database

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil data dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Periksa apakah ID diberikan
if (!isset($data['id']) || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
    exit;
}

$id = intval($data['id']); // Pastikan ID adalah angka

// Cek apakah user dengan ID tersebut ada
$check_sql = "SELECT name, username, phonenumber, email FROM user WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}

// Ambil data lama dari database
$user = $result->fetch_assoc();
$check_stmt->close();

// Ambil nilai baru jika dikirim, jika tidak, gunakan data lama
$name = isset($data['name']) ? trim($data['name']) : $user['name'];
$username = isset($data['username']) ? trim($data['username']) : $user['username'];
$phonenumber = isset($data['phonenumber']) ? trim($data['phonenumber']) : $user['phonenumber'];
$email = isset($data['email']) ? trim($data['email']) : $user['email'];

// Validasi email jika dikirim
if (isset($data['email']) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit;
}

// Update data pengguna
$update_sql = "UPDATE user SET name = ?, username = ?, phonenumber = ?, email = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    $update_stmt->bind_param("ssssi", $name, $username, $phonenumber, $email, $id);

    if ($update_stmt->execute()) {
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Database error: " . $update_stmt->error]);
    }

    $update_stmt->close();
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to prepare statement"]);
}

$conn->close();
?>
