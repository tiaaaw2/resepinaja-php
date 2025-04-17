<?php
header("Content-Type: application/json");
require "config.php"; // File koneksi database

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil data dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Periksa apakah email dan password ada
if (!isset($data['email'], $data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

// Ambil data user berdasarkan email
$sql = "SELECT id, email, password FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah email ada di database
if ($result->num_rows === 0) {
    http_response_code(401); // Unauthorized
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}

$user = $result->fetch_assoc();

// Bandingkan password (karena tanpa enkripsi, langsung dicocokkan)
if ($password !== $user['password']) {
    http_response_code(401); // Unauthorized
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}

// Jika login berhasil, kirim respons
http_response_code(200); // OK
echo json_encode([
    "status" => "success",
    "message" => "Login successful",
    "user" => [
        "id" => $user['id'],
        "email" => $user['email']
    ]
]);

$stmt->close();
$conn->close();
?>
