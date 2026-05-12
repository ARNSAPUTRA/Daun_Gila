<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Pengenalan Daun</title>

    <link rel="stylesheet" href="assets/style.css?v=<?php echo time(); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo-box">

        <div class="logo-circle">
            🌿
        </div>

        <div>
            <h2>AI Daun</h2>
            <p>Media Pembelajaran</p>
        </div>

    </div>

    <div class="menu-title">
        MENU
    </div>

    <a href="#" class="menu active">
        🏠 Dashboard
    </a>

    <a href="#" class="menu">
        📚 Edukasi Daun
    </a>

    <a href="#" class="menu">
        🤖 Tentang AI
    </a>

    <div class="sidebar-footer">
        🌱 Belajar sambil bermain
    </div>

</div>

<!-- MAIN -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="search-box">

            <input type="text" placeholder="Cari jenis daun...">

        </div>

    </div>

    <!-- HERO -->
    <div class="hero">

        <div class="hero-text">

            <h1>
                🌿 Klasifikasi Sayuran daun hijau
            </h1>

            <p>
                Upload gambar daun untuk dikenali menggunakan Artificial Intelligence.
            </p>

        </div>

    </div>

    <!-- CARD EDUKASI -->
    <div class="card-grid">

        <div class="leaf-card">
            <img src="assets/daun2.jpg">
            <div class="leaf-info">
                <h3>Daun Kelor</h3>
                <p>Kaya vitamin dan baik untuk kesehatan.</p>
            </div>
        </div>

        <div class="leaf-card">
            <img src="assets/daun3.jpg">
            <div class="leaf-info">
                <h3>Daun Pepaya</h3>
                <p>Sering digunakan sebagai obat herbal.</p>
            </div>
        </div>

        <div class="leaf-card">
            <img src="assets/daun1.jpg">
            <div class="leaf-info">
                <h3>Daun Singkong</h3>
                <p>Daun hijau yang bergizi tinggi.</p>
            </div>
        </div>

    </div>

    <!-- UPLOAD -->
    <div class="predict-grid">

        <!-- FORM -->
        <div class="upload-card">

            <h2>📷 Upload Gambar Daun</h2>

            <p>
                Pilih gambar daun untuk diprediksi model AI.
            </p>

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="upload-area">

                    <input type="file" name="gambar" required>

                </div>

                <button type="submit" name="submit">
                    🚀 Prediksi Sekarang
                </button>

            </form>

        </div>

        <!-- HASIL -->
        <div class="result-card">

<?php

if(isset($_POST['submit'])){

    $target_dir = "upload/";

    $file_name = time() . '_' . basename($_FILES["gambar"]["name"]);

    $target_file = $target_dir . $file_name;

    if(move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)){

        $python = "C:\\Users\\MyBook Hype AMD\\AppData\\Local\\Programs\\Python\\Python312\\python.exe";

        $script = "C:\\xampp3\\htdocs\\projec_daun\\pyton\\predict.py";

        $command = "\"$python\" \"$script\" \"$target_file\" 2>&1";

        $output = shell_exec($command);

        echo "<h2>🌱 Hasil Prediksi</h2>";

        echo "<div class='preview-box'>";
        echo "<img src='$target_file'>";
        echo "</div>";

        echo "<pre>$output</pre>";

    }else{

        echo "<h2>❌ Upload gagal</h2>";

    }

}else{

    echo "<h2>🌱 Hasil Prediksi</h2>";
    echo "<p class='empty-text'>Belum ada prediksi. Upload gambar terlebih dahulu.</p>";

}

?>

        </div>

    </div>

</div>

</body>
</html>