
<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];

       header("Location: index.html");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login JobListing</title>

    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
     <header id="header" id="home">
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="index.html">Home</a></li>
				          <li><a href="about-us.html">About Us</a></li>
				          <li><a href="category.html">Category</a></li>
				          <li><a href="price.html">Price</a></li>
				          <li><a href="blog-home.html">Blog</a></li>
				          <li><a href="contact.html">Contact</a></li>
				          <li class="menu-has-children"><a href="">Pages</a>
				            <ul>
								<li><a href="elements.html">elements</a></li>
								<li><a href="search.html">search</a></li>
								<li><a href="single.html">single</a></li>
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
                <h1 class="text-white">
    Login JobListing
</h1>

                <p class="text-white">
                    Masuk untuk menemukan peluang kerja terbaik
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email"
                           class="form-control"
                           placeholder="Masukkan email"
                           required>
                </div>

                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="password"
                           class="form-control"
                           placeholder="Masukkan password"
                           required>
                </div>

                <button type="submit" name="login"
        class="btn btn-info btn-block">
    Login
</button>
            </form>

            <p class="text-center mt-3">
                Belum punya akun?
                <a href="register.php">Daftar sekarang</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
