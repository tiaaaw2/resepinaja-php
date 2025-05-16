<?php

include "../config.php";

    $id = $_GET['id'];
  
    
    $query = "UPDATE resep SET status=0 WHERE id=$id";

    $data = mysqli_query($conn, $query);

    if ($data) {
      header("Location: index.php");
      echo " Data di draft";      
    }
    
?>