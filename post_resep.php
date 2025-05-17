<?php
header("Content-Type: application/json");
require "config.php";

function uploadImage($image) {
  $targetDir = "uploads/";
  $targetFile = $targetDir . basename($image["name"]);
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the file is an actual image
  $check = getimagesize($image["tmp_name"]);
  if ($check === false) {
    return ["status" => "error", "message" => "File is not an image."];
  }

  // Check file size (500KB limit)
  if ($image["size"] > 500000) {
    return ["status" => "error", "message" => "Sorry, your file is too large. Max 500KB allowed."];
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" &&
    $imageFileType != "jpeg" && $imageFileType != "gif"
  ) {
    return ["status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
  }

  // Create directory if it doesn't exist
  if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  // Attempt to move the uploaded file
  if (move_uploaded_file($image["tmp_name"], $targetFile)) {
    return ["status" => "success", "filePath" => $targetFile]; // Return success status and file path
  } else {
    return ["status" => "error", "message" => "Sorry, there was an error uploading your file."];
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_FILES["image"])) {
    $uploadResult = uploadImage($_FILES["image"]);

    if ($uploadResult["status"] === "success") {
      // Sanitize and escape input data
      $title = $conn->real_escape_string($_POST['title']);
      $id = $conn->real_escape_string($_POST['id']);
      $ingredients = $conn->real_escape_string($_POST['ingredients']);
      $steps = $conn->real_escape_string($_POST['steps']);
      $image_url = $conn->real_escape_string($uploadResult["filePath"]); // Use the file path from upload result

      // Insert data into the database
      $sql = "INSERT INTO resep (title, id_user, ingredients, steps, image_url) VALUES ('$title', '$id', '$ingredients', '$steps', '$image_url')";

      if ($conn->query($sql) === TRUE) {
        echo json_encode([
          "status" => "success",
          "message" => "Recipe added successfully"
        ]);
      } else {
        echo json_encode([
          "status" => "error",
          "message" => "Database Error: " . $conn->error
        ]);
      }
    } else {
      // Return specific error message from upload function
      echo json_encode([
        "status" => "error",
        "message" => $uploadResult["message"]
      ]);
    }
  } else {
    echo json_encode([
      "status" => "error",
      "message" => "No image uploaded."
    ]);
  }
} else {
  echo json_encode([
    "status" => "error",
    "message" => "Invalid request method."
  ]);
}

$conn->close();
?>
