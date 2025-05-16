<?php
header("Content-Type: application/json");
require "config.php"; // File koneksi database

// Function to handle image upload with dimension constraints
function uploadImage($image, $maxWidth = null, $maxHeight = null) {
    $targetDir = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        return false; // Not an image
    }

    // Check file size (adjust as needed)
    if ($image["size"] > 5000000) { // Increased file size limit to 5MB as an example
        return false; // File too large
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" &&
        $imageFileType != "jpeg" && $imageFileType != "gif"
    ) {
        return false; // Invalid file type
    }

    // Check image dimensions if maxWidth or maxHeight are provided
    if ($maxWidth !== null || $maxHeight !== null) {
        list($width, $height) = $check; // Get actual image dimensions
        if (($maxWidth !== null && $width > $maxWidth) || ($maxHeight !== null && $height > $maxHeight)) {
            // Image dimensions exceed the allowed limits
            return false;
        }
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


// Pastikan metode yang digunakan adalah POST dan tipe konten adalah multipart/form-data (secara implisit melalui $_POST dan $_FILES)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil data dari $_POST
// Periksa apakah ID diberikan
if (!isset($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
    exit;
}

$id = intval($_POST['id']); // Pastikan ID adalah angka

// Cek apakah user dengan ID tersebut ada
$check_sql = "SELECT name, username, phonenumber, email, image_url FROM user WHERE id = ?";
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

// Ambil nilai baru jika dikirim melalui POST, jika tidak, gunakan data lama
$name = isset($_POST['name']) ? trim($_POST['name']) : $user['name'];
$username = isset($_POST['username']) ? trim($_POST['username']) : $user['username'];
$phonenumber = isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : $user['phonenumber'];
$email = isset($_POST['email']) ? trim($_POST['email']) : $user['email'];

// Validasi email jika dikirim
if (isset($_POST['email']) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit;
}

$image_url = $user['image_url']; // Default to existing image URL

// Tangani upload gambar jika ada
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Define the max dimensions based on React Native options
    $maxWidth = 2000;
    $maxHeight = 2000;

    $uploadResult = uploadImage($_FILES['image'], $maxWidth, $maxHeight);

    if ($uploadResult !== false) {
        $image_url = $conn->real_escape_string($uploadResult); // Gunakan jalur file yang diunggah
    } else {
        // Jika upload gambar gagal (termasuk karena dimensi), kembalikan error
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Failed to upload image or image dimensions exceed limits"]);
        exit;
    }
}


// Update data pengguna
$update_sql = "UPDATE user SET name = ?, username = ?, phonenumber = ?, email = ?, image_url = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    $update_stmt->bind_param("sssssi", $name, $username, $phonenumber, $email, $image_url, $id);

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
