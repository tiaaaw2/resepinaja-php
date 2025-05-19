<?php
include "../config.php";

$username = $_POST['username']; 
$pass     = $_POST['password']; 
$login = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password='$pass' AND role='admin'"); 
$row=mysqli_fetch_array($login,MYSQLI_ASSOC); 
if ($row['username'] == $username AND $row['password'] == $pass) 
{ 
  session_start(); 
  $_SESSION['username'] = $row['username']; 
  $_SESSION['password'] = $row['password']; 
  header('location:index.php'); 
} 
else 
{ 
  echo "<center><br><br><br><br><br><br><b>LOGIN FAILED! </b><br> 
        Wrong username or password.<br>"; 
  echo "<br>"; 
  echo "<a href='javascript:history.back()'>TRY AGAIN</a></center>"; 
} 
?>
