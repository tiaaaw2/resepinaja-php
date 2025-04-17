<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Resepin-aja</title>

    <!-- Bootstrap CSS CDN -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Bootstrap Icons CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css"
    />

    <!-- Custom Styling -->
    <style>
      body {
        margin: 0;
        font-family: "Open Sans", sans-serif;
        background-color: #fff;
      }

      .sidebar {
        background-color: #f0f0f0;
        min-height: 100vh;
        padding: 20px;
        color: rgb(0, 0, 0);
      }

      .sidebar .logo {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        font-family: "Open Sans", sans-serif;
      }

      .sidebar a {
        color: rgb(0, 0, 0);
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        font-size: 15px;
      }

      .sidebar a:hover {
        background-color: #e3e3e3;
      }

      .content {
        padding: 30px;
      }

      .table thead {
        background-color: #f8f9fa;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
          <div class="logo">Resepin-aja</div>
          <a href="index.php"><i class="bi bi-arrow-repeat"></i> Pending Resep</a>
          <a href="resep.php"><i class="bi bi-book"></i> Resep</a>

          <a href="#"><i class="bi bi-door-open"></i>Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 content">
          <h2 class="mb-4">Data Resep</h2>

          <!-- Tabel Data -->
           <p>ini index</p>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover " style="font-size: 13px;">
              <thead style="text-align: center">
                <tr>
                  <th>No</th>
                  <th>Title</th>
                  <th>Ingredients</th>
                  <th style="max-width:100px;">Steps</th>
                  <th>Image</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  include('../config.php');
                  $no = 1;
                  $query = "SELECT * FROM resep ORDER BY created_at DESC";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <td  ><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['ingredients'])); ?></td>
                    <td style="max-width: 200px;"><?= nl2br(htmlspecialchars($row['steps'])); ?></td>
                    <td>
                      <img src="<?= htmlspecialchars($row['image_url']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="img-fluid" style="max-width: 100px; height: auto;" />
                    </td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                  </tr>
                  <?php
                  }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS (Opsional, jika butuh interaktivitas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
