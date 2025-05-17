<?php
header("Content-Type: application/json");
require "config.php";
$search = isset($_GET['search']) ? $_GET['search'] : "";
$search = $conn->real_escape_string($search);
$sql = "SELECT 
    r.id,
    r.title,
    r.id_user,
    r.ingredients,
    r.steps,
    r.image_url,
    r.created_at,
    r.status,
    u.name AS user_name
FROM 
    resep r
JOIN 
    user u ON r.id_user = u.id 
WHERE 
    r.status = 1 
    AND r.title LIKE '%$search%'
ORDER BY 
    r.created_at DESC;";

$result = $conn->query($sql);

// Cek hasil
if ($result->num_rows > 0) {
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $recipes]);
} else {
    echo json_encode(["status" => "error", "message" => "No recipes found"]);
}

$conn->close();
?>
