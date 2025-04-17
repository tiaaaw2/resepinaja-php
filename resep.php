<?php

$host = "localhost";
$user = "root";  
$pass = "";  
$dbname = "db_resepinaja";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}else{
    echo "Koneksi berhasil!";
}

$sql = "SELECT * FROM resep";
$result = $conn->query($sql);

// Buat variabel untuk menyimpan data
$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; 
    }
}

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// $recipes = [
//     [
//         "id" => 1,
//         "title" => "Nasi Goreng Spesial",
//         "author" => "Chef Andi",
//         "created_at" => "2025-01-29",
//         "duration" => 30, // dalam menit
//         "ingredients" => "Nasi, telur, kecap manis, bawang putih, bawang merah, ayam, garam, merica",
//         "steps" => "Panaskan minyak, tumis bawang putih dan bawang merah, Masukkan ayam, aduk rata, Tambahkan nasi, tambahkan kecap manis, tambahkan garam, dan tambahkan merica. Aduk rata dan sajikan.",
//         "image_url" => "https://asset.kompas.com/crops/Slbj_ngGVguffqNkbgjtdZqd8OU=/13x7:700x465/1200x800/data/photo/2021/09/24/614dc6865eb24.jpg"
//     ],
//     [
//         "id" => 2,
//         "title" => "Mie Goreng Pedas",
//         "author" => "Chef Budi",
//         "created_at" => "2025-01-28",
//         "duration" => 20,
//         "ingredients" => "Mie, bawang putih, bawang merah, cabai, kecap manis, saus sambal, telur, garam, merica",
//         "steps" => "1. Rebus mie hingga matang, tiriskan. 2. Panaskan minyak, tumis bawang putih, bawang merah, dan cabai. 3. Masukkan telur, aduk rata. 4. Tambahkan mie, kecap manis, saus sambal, garam, dan merica. 5. Aduk rata dan sajikan.",
//         "image_url" => "https://img-global.cpcdn.com/recipes/f20f426816946317/1200x630cq70/photo.jpg"
//     ],
//     [
//         "id" => 3,
//         "title" => "Soto Ayam",
//         "author" => "Chef Citra",
//         "created_at" => "2025-01-27",
//         "duration" => 45,
//         "ingredients" => "Ayam, kunyit, bawang putih, bawang merah, serai, daun jeruk, garam, merica",
//         "steps" => "1. Rebus ayam dengan bumbu hingga matang. 2. Suwir ayam dan sajikan dengan kuah soto.",
//         "image_url" => "https://source.unsplash.com/400x300/?chicken-soup"
//     ],
//     [
//         "id" => 4,
//         "title" => "Ayam Bakar Madu",
//         "author" => "Chef Dimas",
//         "created_at" => "2025-01-26",
//         "duration" => 60,
//         "ingredients" => "Ayam, madu, kecap manis, bawang putih, bawang merah, garam, merica",
//         "steps" => "1. Marinasi ayam dengan bumbu selama 30 menit. 2. Bakar ayam hingga matang dan kecoklatan. 3. Sajikan dengan nasi hangat.",
//         "image_url" => "https://source.unsplash.com/400x300/?grilled-chicken"
//     ],
//     [
//         "id" => 5,
//         "title" => "Gado-Gado",
//         "author" => "Chef Erika",
//         "created_at" => "2025-01-25",
//         "duration" => 25,
//         "ingredients" => "Tahu, tempe, lontong, telur, sayuran, bumbu kacang",
//         "steps" => "1. Rebus sayuran hingga matang. 2. Goreng tahu dan tempe. 3. Campur semua bahan dengan bumbu kacang dan sajikan.",
//         "image_url" => "https://source.unsplash.com/400x300/?gado-gado"
//     ],
//     [
//         "id" => 6,
//         "title" => "Rendang Sapi",
//         "author" => "Chef Fajar",
//         "created_at" => "2025-01-24",
//         "duration" => 180,
//         "ingredients" => "Daging sapi, santan, bawang putih, bawang merah, serai, daun jeruk, rempah-rempah",
//         "steps" => "1. Tumis bumbu hingga harum. 2. Masukkan daging sapi dan santan, masak dengan api kecil hingga empuk. 3. Aduk sesekali hingga kuah mengering dan rendang siap disajikan.",
//         "image_url" => "https://source.unsplash.com/400x300/?rendang"
//     ],
//     [
//         "id" => 7,
//         "title" => "Bakso Kuah",
//         "author" => "Chef Gina",
//         "created_at" => "2025-01-23",
//         "duration" => 40,
//         "ingredients" => "Bakso, kaldu ayam, bawang putih, bawang merah, daun seledri, mie",
//         "steps" => "1. Didihkan kaldu ayam. 2. Masukkan bakso dan bumbu. 3. Sajikan dengan mie dan daun seledri.",
//         "image_url" => "https://source.unsplash.com/400x300/?meatball-soup"
//     ],
//     [
//         "id" => 8,
//         "title" => "Es Cendol",
//         "author" => "Chef Hana",
//         "created_at" => "2025-01-22",
//         "duration" => 15,
//         "ingredients" => "Cendol, santan, gula merah, es batu",
//         "steps" => "1. Rebus gula merah hingga larut. 2. Campur cendol dengan santan dan es batu. 3. Tambahkan larutan gula merah dan sajikan.",
//         "image_url" => "https://source.unsplash.com/400x300/?cendol"
//     ],
//     [
//         "id" => 9,
//         "title" => "Pisang Goreng",
//         "author" => "Chef Ilham",
//         "created_at" => "2025-01-21",
//         "duration" => 20,
//         "ingredients" => "Pisang, tepung terigu, gula, garam, minyak",
//         "steps" => "1. Campur tepung terigu dengan gula dan garam. 2. Celupkan pisang ke dalam adonan, lalu goreng hingga keemasan.",
//         "image_url" => "https://source.unsplash.com/400x300/?fried-banana"
//     ],
//     [
//         "id" => 10,
//         "title" => "Sayur Asem",
//         "author" => "Chef Joko",
//         "created_at" => "2025-01-20",
//         "duration" => 35,
//         "ingredients" => "Asam jawa, jagung, labu siam, kacang panjang, daun melinjo",
//         "steps" => "1. Rebus air dan asam jawa hingga mendidih. 2. Masukkan semua sayuran dan bumbu, masak hingga matang.",
//         "image_url" => "https://source.unsplash.com/400x300/?vegetable-soup"
//     ]
// ];

echo json_encode($recipes, JSON_PRETTY_PRINT);
?>
