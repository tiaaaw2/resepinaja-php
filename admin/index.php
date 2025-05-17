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
      .table td {
        word-wrap: break-word;
        white-space: normal;
        vertical-align: top;
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

          <!-- <a href="#"><i class="bi bi-door-open"></i>Logout</a> -->
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 content ">
          <h2 class="mb-4">Pending Resep</h2>

          <!-- Tabel Data -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover " style="font-size: 13px;">
              <thead style="text-align: center">
                <tr>
                  <th>No</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Ingredients</th>
                  <th style="max-width:100px;">Steps</th>
                  <th>Status</th>
                  <th>action</th>

                </tr>
              </thead>
              <tbody>
                  <?php
                  include('../config.php');
                  $no = 1;
                  $query = "SELECT * FROM resep WHERE status=0 ORDER BY created_at DESC";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <td  ><?= $no++; ?></td>
                       <td>
                        <img src="<?= htmlspecialchars('http://192.168.163.118/api-resep/' . $row['image_url']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="img-fluid" style="max-width: 150px; height: 150px; object-fit: contain;" />
                      </td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;"><?= nl2br(htmlspecialchars($row['ingredients'])); ?></td>
                    <td style="max-width: 200px; word-wrap: break-word; white-space: normal;"><?= nl2br(htmlspecialchars($row['steps'])); ?></td>
                 
                    <td>Pending / draft</td>
                    <td>
                      <a href="approve.php?id=<?= $row['id']; ?>" 
                        class="btn btn-success btn-sm" 
                        onclick="return confirm('Apakah Anda yakin ingin menyetujui item ini?');">
                        approved
                      </a>
                      <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Apakah Anda yakin ingin menolak resep ini?');">reject
                      </a>                    
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
