
<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "Email sudah terdaftar!";
    } else {
        $query = "INSERT INTO users (nama, email, password, no_hp)
                  VALUES ('$nama', '$email', '$password', '$no_hp')";

        if (mysqli_query($koneksi, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $pesan = "Registrasi gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JobBoard</title>

   <link rel="stylesheet" href="css/linearicons.css">
<link rel="stylesheet" href="css/font-awesome.min.css">

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/magnific-popup.css">
<link rel="stylesheet" href="css/nice-select.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/main.css">

<style>
html {
    overflow-y: auto !important;
}

body {
    overflow-y: auto !important;
    height: auto !important;
    padding-bottom: 50px;
}
</style>
</head>
<body>
     <header id="header" id="home">
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="index.php">Home</a></li>
				          <li><a href="about-us.php">About Us</a></li>
				          <li><a href="category.php">Category</a></li>
				          <li><a href="price.php">Price</a></li>
				          <li><a href="blog-home.php">Blog</a></li>
				          <li><a href="contact.php">Contact</a></li>
				          <li class="menu-has-children"><a href="">Pages</a>
				            <ul>
								<li><a href="elements.php">elements</a></li>
								<li><a href="search.php">search</a></li>
								<li><a href="single.php">single</a></li>
				            </ul>
				          </li>
				          <li><a class="ticker-btn" href="register.php">Signup</a></li>
<li><a class="ticker-btn" href="login.php">Login</a></li>			          				          
				        </ul>
				      </nav><!-- #nav-menu-container -->		    		
			    	</div>
			    </div>
<section class="banner-area relative" id="home">
    <div class="overlay overlay-bg"></div>

    <div class="container">
        <div class="row d-flex align-items-center justify-content-center"
             style="min-height: 300px; padding-top: 80px;">
            <div class="banner-content col-lg-12 text-center">
                <h1 class="text-white">Register JobListing</h1>

                <p class="text-white">
                    Buat akun untuk menemukan peluang kerja terbaik
                </p>
            </div>
        </div>
    </div>
</section>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <h2 class="text-center mb-4">Register JobBoard</h2>

                <p class="text-danger text-center">
                    <?php echo $pesan; ?>
                </p>

                <form method="POST">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Nomor HP</label>
                        <input type="text" name="no_hp"
                               class="form-control" required>
                    </div>

                    <button type="submit" name="register"
        class="btn btn-info w-100">
    Register
</button>
                </form>

                <p class="text-center mt-3">
                    Sudah punya akun?
                    <a href="login.php">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
