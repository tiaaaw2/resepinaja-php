<?php
header("Content-Type: application/json");
require "config.php";

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari body request
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['title'], $data['id'], $data['ingredients'], $data['steps'], $data['image_url'])) {
        $title = $conn->real_escape_string($data['title']);
        $id = $conn->real_escape_string($data['id']);
        $ingredients = $conn->real_escape_string($data['ingredients']);
        $steps = $conn->real_escape_string($data['steps']);
        $image_url = $conn->real_escape_string($data['image_url']);
        
        $sql = "INSERT INTO resep (title, id_user, ingredients, steps, image_url) VALUES ('$title', '$id', '$ingredients', '$steps', '$image_url')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Recipe added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>
