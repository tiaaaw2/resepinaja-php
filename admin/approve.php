<?php

include "../config.php";

    $id = $_GET['id'];
  
    
    $query = "UPDATE resep SET status=1 WHERE id=$id";

    $data = mysqli_query($conn, $query);

    if ($data) {
      header("Location: resep.php");
      echo " Data di setujui";      
          
    } else {
      echo " Data Gagal Disimpan";
    }
    
?>