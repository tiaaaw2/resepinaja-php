<?php
    session_start();
    if(!empty($_SESSION['username'])){
    header("location:index.php");  
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./img/logo.png">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body style="background-color: #FFF8E1;"> <!-- latar lembut -->

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-8"> 
          <div class="card border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="row align-items-center">
                
                <!-- Form Login - kiri -->
                <div class="col-lg-6">
                  <div class="p-5">
                    <!-- Logo & Judul -->
                    <div class="d-flex align-items-center mb-4">
                      <img src="img/logo.png" alt="Logo" style="width: 55px; height: 55px; margin-right: 10px;">
                      <h1 class="m-0" style="color: #EFBC5D; font-weight: bold; font-size: 28px;">
                        Resepi-in <span style="color: rgb(0, 0, 0);">aja</span>
                      </h1>
                    </div>

                    <!-- Form Login -->
                    <form action="login_process.php" method="POST">
                      <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" placeholder="username"
                          style="background-color: #FFF0DC; border: 1px solid #f7f7f8;">
                      </div>
                      
                      <div class="form-group mb-4">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Your Password"
                          style="background-color: #FFF0DC; border: 1px solid #f7f7f8;">
                      </div>

                      <div class="text-center">
                      <button  class="btn w-100 text-white" style="background-color: #EFBC5D; border: none; border-radius: 15px; padding: 10px; font-weight: bold;" type="submit" name="login" title="Login"><b>SIGN IN</b></button> 
                      
                      </div>
                    </form>
                  </div>
                </div>

                <!-- Gambar di kanan -->
                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center h-100">
                <img src="img/loginside.png" alt="Login Side" 
                    style="width: 100%; height: auto; object-fit: cover; border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                </div>
              </div> <!-- end row -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>
