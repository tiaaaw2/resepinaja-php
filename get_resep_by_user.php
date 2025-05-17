<?php
header("Content-Type: application/json");
require "config.php";

if (isset($_GET['id_user'])) {
    $id_user = intval($_GET['id_user']); 

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
                r.id_user = ?
            ORDER BY 
                r.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $recipes]);
    } else {
        echo json_encode(["status" => "error", "message" => "No recipes found for this user"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "User ID is required"]);
}

$conn->close();
?>
