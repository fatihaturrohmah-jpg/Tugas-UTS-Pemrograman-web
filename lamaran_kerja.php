<?php
// Hubungkan ke file koneksi database jika ada
// include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Lamaran Kerja</title>
    
    <!-- CSS Bawaan Template -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Formulir Lamaran Kerja</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="posisi" class="form-label">Posisi yang Dilamar</label>
                        <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Contoh: Web Developer" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cv" class="form-label">Upload CV / Berkas (PDF)</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="pesan" class="form-label">Surat Lamaran / Pesan Singkat</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Tuliskan alasan kamu melamar posisi ini..."></textarea>
                    </div>

                    <button type="submit" name="kirim" class="btn btn-primary px-4">Kirim Lamaran</button>
                    <a href="index.html" class="btn btn-secondary px-4">Batal</a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>