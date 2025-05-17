<?php
include "../config.php";
    $id = $_GET['id'];
    $hapus = "DELETE FROM resep WHERE id = $id";
    $query = mysqli_query($conn, $hapus);

    if ($query) {
  if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
    }
?>
