<?php
header("Content-Type: application/json");
require "config.php";

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $id = $conn->real_escape_string($data['id']);

        $sql = "DELETE FROM resep WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Recipe deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing recipe ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>
