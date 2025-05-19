<?php
header("Content-Type: application/json");
require "config.php"; 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email'], $data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

$sql = "SELECT id, email, password FROM user WHERE email = ? AND role = 'user'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401); 
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}
$user = $result->fetch_assoc();
if ($password !== $user['password']) {
    http_response_code(401); 
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}
http_response_code(200); 
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
