<?php

include "../config.php";

    $id = $_GET['id'];
    $hapus = "DELETE FROM resep WHERE id = $id";
    $query = mysqli_query($conn, $hapus);

    if ($query) {
  if (isset($_SERVER['HTTP_REFERER'])) {
        // Redirect back to the referring page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // If HTTP_REFERER is not set, redirect to a default page
        header("Location: index.php"); // Replace with your default page
        exit();
    }
    }
?>
