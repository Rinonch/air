<?php
session_start();

// Database connection
include './assets/func.php';
$air = new klas_air;
$koneksi = $air -> koneksi();

// Masuk data ke tabel user
// $pass = password_hash("warga", PASSWORD_DEFAULT);
// mysqli_query($koneksi, "INSERT INTO user (username, password, nama, alamat, kota, telp, level, tipe, status) VALUES ('warga', '$pass', 'Warga', 'Polines', 'Semarang', '024111', 'warga', '-', 'AKTIF')");
// if (mysqli_affected_rows($koneksi) > 0) {
//     echo "Data berhasil dimasukkan";
// } else { 
//     echo "Data gagal dimasukkan";
// }
// ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="./css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <?php
                                        if (isset($_POST['tombol'])) {
                                            $username = isset($_POST['username']) ? $_POST['username'] : ''; // Use 'username' instead of 'user'
                                            $password = isset($_POST['password']) ? $_POST['password'] : '';

                                            // Query to check if the user exists
                                            $qc = mysqli_query($koneksi, "SELECT username, password FROM user WHERE username='$username'");
                                            if ($qc && mysqli_num_rows($qc) > 0) {
                                                $dc = mysqli_fetch_row($qc);

                                                if (!empty($dc[0])) $user_cek=$dc[0];
                                                $user_cek = $dc[0];

                                                if (!empty($user_cek)) {
                                                    // Check if the password matches
                                                    $pass_cek = $dc[1];

                                                    // Verifikasi
                                                    if (password_verify($password, $pass_cek)) {
                                                        // Daftar session
                                                        $_SESSION['user'] = $username;
                                                        $_SESSION['pass'] = $password;

                                                        // Redirect ke dashboard 
                                                        echo "<script>window.location.replace('./login/index.php')</script>";

                                                    } else {
                                                        echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Login!</strong> gagal</div>';
                                                    }
                                                }
                                            } else {
                                                echo '<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><strong>Username!</strong> tidak ditemukan</div>';
                                            }
                                        }
                                        ?>
                                        <form method="POST" class="needs-validation">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputUser" type="text" placeholder="Username" name="username" required />
                                                <label for="inputUser">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input type="submit" name="tombol" value="Login" class="btn btn-primary" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website <?php echo date("Y")?></div>
                            <div>
                                <a href="./profile/profile.html">Profile</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./js/scripts.js"></script>
    </body>
</html>
