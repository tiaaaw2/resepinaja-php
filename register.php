<?php
header("Content-Type: application/json");
require "config.php"; 
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); 
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email'], $data['password'])) {
    http_response_code(400); 
    echo json_encode(["status" => "error", "message" => "Email and password are required"]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit;
}
$check_sql = "SELECT id FROM user WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["status" => "error", "message" => "Email already registered"]);
    exit;
}
$check_stmt->close();
$insert_sql = "INSERT INTO user (name, username, phonenumber, email, password) VALUES ('', '', '', ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);

if ($insert_stmt) {
    $insert_stmt->bind_param("ss", $email, $password);

    if ($insert_stmt->execute()) {
        http_response_code(201);
        echo json_encode(["status" => "success", "message" => "User registered successfully"]);
    } else {
        http_response_code(500); 
        echo json_encode(["status" => "error", "message" => "Database error: " . $insert_stmt->error]);
    }

    $insert_stmt->close();
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to prepare statement"]);
}

$conn->close();
?>
