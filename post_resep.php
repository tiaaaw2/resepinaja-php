<?php
header("Content-Type: application/json");
require "config.php";

// Function to handle image upload
function uploadImage($image) {
  $targetDir = "uploads/"; // Directory where images will be stored
  $targetFile = $targetDir . basename($image["name"]);
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($image["tmp_name"]);
  if ($check === false) {
    return false; // Not an image
  }

  // Check file size (adjust as needed)
  if ($image["size"] > 500000) {
    return false; // File too large
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" &&
    $imageFileType != "jpeg" && $imageFileType != "gif"
  ) {
    return false; // Invalid file type
  }

  // Create directory if it doesn't exist
  if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  // Try to upload file
  if (move_uploaded_file($image["tmp_name"], $targetFile)) {
    return $targetFile; // Return the path to the uploaded image
  } else {
    return false; // Upload failed
  }
}

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Pastikan ada file yang diunggah
  if (isset($_FILES["image"])) {
    $uploadResult = uploadImage($_FILES["image"]);

    if ($uploadResult !== false) {
      // Ambil data dari body request
      $title = $conn->real_escape_string($_POST['title']);
      $id = $conn->real_escape_string($_POST['id']);
      $ingredients = $conn->real_escape_string($_POST['ingredients']);
      $steps = $conn->real_escape_string($_POST['steps']);
      $image_url = $conn->real_escape_string($uploadResult); // Use the path from upload

      $sql = "INSERT INTO resep (title, id_user, ingredients, steps, image_url) VALUES ('$title', '$id', '$ingredients', '$steps', '$image_url')";

      if ($conn->query($sql) === TRUE) {
        echo json_encode([
          "status" => "success",
          "message" => "Recipe added successfully"
        ]);
      } else {
        echo json_encode([
          "status" => "error",
          "message" => "Error: " . $conn->error
        ]);
      }
    } else {
      echo json_encode([
        "status" => "error",
        "message" => "Failed to upload image"
      ]);
    }
  } else {
    echo json_encode([
      "status" => "error",
      "message" => "No image uploaded"
    ]);
  }
} else {
  echo json_encode([
    "status" => "error",
    "message" => "Invalid request method"
  ]);
}

$conn->close();
?>
