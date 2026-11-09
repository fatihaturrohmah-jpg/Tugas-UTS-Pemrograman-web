<?php
session_start();
include 'koneksi.php'; // Sesuaikan dengan nama file koneksi database Anda

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$action  = isset($_GET['action']) ? $_GET['action'] : 'index';
$id      = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error   = '';

// ==========================================
// 1. LOGIKA PROSES (POST / DELETE)
// ==========================================

// PROSES TAMBAH LAMARAN (CREATE)
if ($action == 'store' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id         = intval($_POST['job_id']);
    $cv_link        = mysqli_real_escape_string($koneksi, $_POST['cv_link']);
    $portfolio_link = mysqli_real_escape_string($koneksi, $_POST['portfolio_link']);
    $no_hp          = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    $query = "INSERT INTO applications (user_id, job_id, cv_link, portfolio_link, no_hp, status) 
              VALUES ('$user_id', '$job_id', '$cv_link', '$portfolio_link', '$no_hp', 'Pending')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: lamaran.php");
        exit();
    } else {
        $error = "Gagal mengirim lamaran: " . mysqli_error($koneksi);
    }
}

// PROSES UPDATE LAMARAN (UPDATE)
if ($action == 'update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $cv_link        = mysqli_real_escape_string($koneksi, $_POST['cv_link']);
    $portfolio_link = mysqli_real_escape_string($koneksi, $_POST['portfolio_link']);
    $no_hp          = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    $query = "UPDATE applications 
              SET cv_link = '$cv_link', portfolio_link = '$portfolio_link', no_hp = '$no_hp' 
              WHERE id = '$id' AND user_id = '$user_id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: lamaran.php");
        exit();
    } else {
        $error = "Gagal mengupdate lamaran: " . mysqli_error($koneksi);
    }
}

// PROSES HAPUS LAMARAN (DELETE)
if ($action == 'delete') {
    $query = "DELETE FROM applications WHERE id = '$id' AND user_id = '$user_id'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: lamaran.php");
        exit();
    } else {
        $error = "Gagal menghapus lamaran: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lamaran Kerja</title>
    <!-- Menggunakan CSS dari bawaan template job-listing-master -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container mt-5 mb-5">
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php 
        // ==========================================
        // 2. TAMPILAN FORM TAMBAH (action = create)
        // ==========================================
        if ($action == 'create'): 
            $job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
        ?>
            <h2>Kirim Lamaran Pekerjaan</h2>
            <hr>
            <form action="lamaran.php?action=store" method="POST" class="mt-4">
                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                
                <div class="form-group mb-3">
                    <label>Link CV (Google Drive / Cloud)</label>
                    <input type="url" name="cv_link" class="form-control" placeholder="https://drive.google.com/..." required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Link Portofolio (Opsional)</label>
                    <input type="url" name="portfolio_link" class="form-control" placeholder="https://github.com/... atau website">
                </div>
                
                <div class="form-group mb-3">
                    <label>Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08123456789" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                <a href="lamaran.php" class="btn btn-secondary">Batal</a>
            </form>

        <?php 
        // ==========================================
        // 3. TAMPILAN FORM EDIT (action = edit)
        // ==========================================
        elseif ($action == 'edit'): 
            $query_get = "SELECT * FROM applications WHERE id = '$id' AND user_id = '$user_id'";
            $result_get = mysqli_query($koneksi, $query_get);
            $data = mysqli_fetch_assoc($result_get);

            if (!$data) {
                echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
            } else {
        ?>
            <h2>Edit Lamaran Kerja</h2>
            <hr>
            <form action="lamaran.php?action=update&id=<?php echo $id; ?>" method="POST" class="mt-4">
                <div class="form-group mb-3">
                    <label>Link CV</label>
                    <input type="url" name="cv_link" class="form-control" value="<?php echo htmlspecialchars($data['cv_link']); ?>" required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Link Portofolio</label>
                    <input type="url" name="portfolio_link" class="form-control" value="<?php echo htmlspecialchars($data['portfolio_link']); ?>">
                </div>
                
                <div class="form-group mb-3">
                    <label>Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($data['no_hp']); ?>" required>
                </div>
                
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="lamaran.php" class="btn btn-secondary">Batal</a>
            </form>
        <?php 
            }

        // ==========================================
        // 4. TAMPILAN DAFTAR LAMARAN / READ (Default)
        // ==========================================
        else: 
            $query_list = "SELECT applications.*, jobs.title AS nama_pekerjaan, jobs.company AS nama_perusahaan 
                           FROM applications 
                           JOIN jobs ON applications.job_id = jobs.id 
                           WHERE applications.user_id = '$user_id'
                           ORDER BY applications.id DESC";
            $result_list = mysqli_query($koneksi, $query_list);
        ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Riwayat Lamaran Saya</h2>
                <a href="index.php" class="btn btn-outline-primary">Cari Pekerjaan Lain</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Pekerjaan</th>
                            <th>Perusahaan</th>
                            <th>CV</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($result_list) > 0) {
                            while ($row = mysqli_fetch_assoc($result_list)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pekerjaan']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_perusahaan']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row['cv_link']); ?>" target="_blank" class="btn btn-sm btn-info text-white">Buka Link</a></td>
                            <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                            <td><span class="badge badge-warning"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <a href="lamaran.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="lamaran.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Belum ada lamaran yang terkirim.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>