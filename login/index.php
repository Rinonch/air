<?php
session_start();
if (empty($_SESSION['user']) && empty($_SESSION['pass'])) {
    echo "<script>window.location.replace('../index.php')</script>";
} else {
     // Ambil username dari session
    $user_cek = $_SESSION['user']; // Ambil username dari session
    $password = $_SESSION['pass']; // Ambil password dari session
    $nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : ''; // Ambil nama dari session
    $alamat = isset($_SESSION['alamat']) ? $_SESSION['alamat'] : ''; // Ambil alamat dari session
    $kota = isset($_SESSION['kota']) ? $_SESSION['kota'] : ''; // Ambil kota dari session
    $telp = isset($_SESSION['telp']) ? $_SESSION['telp'] : ''; // Ambil telepon dari session
    $tipe = isset($_SESSION['tipe']) ? $_SESSION['tipe'] : ''; // Ambil tipe dari session
    $status = isset($_SESSION['status']) ? $_SESSION['status'] : ''; // Ambil status dari session
}

// Database connection
include '../assets/func.php';
$level = '';   
$air = new klas_air;
$koneksi = $air->koneksi();
$dt_user = $air->dt_user($_SESSION['user']);
$level = $dt_user[2];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Air Zaidan</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                Dashboard
                            </a>
                            <?php
                            if($level=="admin") {
                            ?>
                                <a class="nav-link" href="index.php?p=user">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Manajemen User
                                </a>
                                <a class="nav-link" href="index.php?p=pemakaian_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Lihat Pemakaian Warga
                                </a>
                                <a class="nav-link" href="index.php?p=pembayaran_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Pembayaran Warga
                                </a>
                                <a class="nav-link" href="index.php?p=ubah_datameter_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Ubah Datameter Warga
                                </a>
                            <?php
                            }
                            elseif($level=="bendahara"){
                            ?>
                                <a class="nav-link" href="index.php?p=pembayaran_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Pembayaran Warga
                                </a>
                                <a class="nav-link" href="index.php?p=ubah_datameter_warga">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Ubah Datameter Warga
                                </a>
                                <?php
                            }
                            elseif($level=="petugas"){
                                ?>
                                    <a class="nav-link" href="index.php?p=pemakaian_warga">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Lihat Pemakaian Warga
                                    </a>
                                    <a class="nav-link" href="index.php?p=ubah_datameter_warga">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Ubah Datameter Warga
                                    </a>
                                    <?php
                            }
                            elseif($level=="warga"){
                                ?>
                                    <a class="nav-link" href="index.php?p=pemakaian_sendiri">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Lihat Pemakaian Sendiri
                                    </a>
                                    <a class="nav-link" href="index.php?p=tagihan_sendiri">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Lihat Tagihan Sendiri
                                    </a>
                                    <a class="nav-link" href="index.php?p=bayar_tagihan_sendiri">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Bayar Tagihan Sendiri
                                    </a>
                                    <?php
                            }
                            ?>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><i class="fa-regular fa-user fa-spin text-warning"></i> Logged in as: <?php echo $dt_user[2]?> </div>
                        <?php echo $dt_user[0].' ('. $dt_user[1].')'; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <?php
                        // echo $_SERVER['REQUEST_URI'];
                        $e = explode("=", $_SERVER['REQUEST_URI']);
                        // echo "<br>[0]: $e[0] --> [1]: $e[1]";
                        if (!empty($e[1])) {
                            if ($e[1] == "user" || $e[1] == "user_edit&user") {
                                $h1 = "Manajemen User";
                                $li = "Menu untuk CRUD User";
                            } elseif ($e[1] == "pemakaian_warga") {
                                $h1 = "Lihat Pemakaian Warga";
                                $li = "Lihat Data Pemakaian Air Warga";
                            } elseif ($e[1] == "pembayaran_warga") {
                                $h1 = "Lihat Pembayaran Warga";
                                $li = "Lihat Data Pembayaran Air Warga";
                            } elseif ($e[1] == "ubah_datameter_warga") {
                                $h1 = "Ubah Datameter Warga";
                                $li = "Ubah Datameter Air Warga";
                            }
                        }
                        else {
                            $h1 = "Dashboard";
                            $li = "Dashboard";
                        }
                        ?>
                        <h1 class="mt-4"><?php echo $h1?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $li?></li>
                        </ol>
                        <?php
                        //echo "sesi user: " . $_SESSION['user']."sesi pass: ".$_SESSION['pass'];

                        //session_destroy();
                        //echo "<br> Setelah session destroy: sesi user: " . $_SESSION['user']."sesi pass: ".$_SESSION['pass'];
                        ?>
                        <div class="row" id="summary">
                        </div>
                        <div class="row" id="chart">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4" id="user_add">
                            <div class="card-header">
                                <i class="fa-solid fa-user-plus me-2 text-success fa-fade"></i>
                                User
                            </div>
                            <div class="card-body">
                                <form method="post" class="needs-validation" id="user_form">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="user" placeholder="Enter username" name="user" value="<?php echo $user_cek ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="paswet" value="<?php echo $password ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama:</label>
                                <input type="text" class="form-control" id="nama" placeholder="Enter nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat:</label>
                                <textarea class="form-control" rows="5" id="alamat" name="alamat"><?php echo htmlspecialchars($alamat); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="kota" class="form-label">Kota:</label>
                                <input type="text" class="form-control" id="kota" placeholder="Enter kota" name="kota" value="<?php echo htmlspecialchars($kota); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">Telepon:</label>
                                <input type="text" class="form-control" id="telp" placeholder="Enter telepon" name="telp" value="<?php echo htmlspecialchars($telp); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="level" class="form-label">Level:</label>
                                <select class="form-select" name="level">
                                <option value="">Level</option>
                                <?php
                                $lv = array("admin", "bendahara", "petugas", "warga");
                                foreach($lv as $lv2) {
                                    if ($level == $lv2) $sel = "SELECTED";
                                    else $sel = "";
                                    echo "<option value= $lv2 $sel>".   ucwords($lv2) . "</option>";
                                }
                                ?>
                                </select>
                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe:</label>
                                <select class="form-select" name="tipe">
                                <option value="">Tipe</option>
                                <?php
                                $t = array("RT", "kos");
                                foreach($t as $t2) {
                                    if ($tipe == $t2) $sel = "SELECTED";
                                    else $sel = "";
                                    echo "<option value=$t2 $sel>".   ucwords($t2) . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" name="status">
                                <option value="">Status</option>
                                <?php
                                $s = array("AKTIF", "TIDAK AKTIF");
                                foreach($s as $s2) {
                                    if ($status == $s2) $sel = "SELECTED";
                                    else $sel = "";
                                    echo "<option value='$s2' $sel>".   ucwords($s2) . "</option>";
                                }
                                ?>
                                </select>
                            </div>    
                            <button type="submit" class="btn btn-primary" name="tombol" value="user_add">Simpan</button>
                            </form>
                            </div>
                        </div>
                        </div>
                        <?php
                        if (isset($_POST['tombol'])) {
                            $t = $_POST['tombol'];
                            if($t == "user_add") {
                                $user_cek = $_POST['user'];
                                $nama = $_POST['nama'];
                                $alamat = $_POST['alamat'];
                                $kota = $_POST['kota'];
                                $telp = $_POST['telp'];
                                $level = $_POST['level'];
                                $tipe = $_POST['tipe'];
                                $status = $_POST['status'];

                                // Cek Username ada atau tidak
                                $qc = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$user_cek'");
                                $qj = mysqli_num_rows($qc);
                                // echo "Hasil cek user: $qj";
                                // Username tidak ada
                                if (empty($qj)) {
                                    mysqli_query($koneksi, "INSERT INTO user (username, password, nama, alamat, kota, telp, level, tipe, status) VALUES ('$user_cek', '$password', \"$nama\", '$alamat', '$kota', '$telp', '$level', '$tipe', '$status')");
                                    if (mysqli_affected_rows($koneksi) > 0) {
                                        echo "<div class='alert alert-success alert-dismissible fade show'>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        <strong>Data </strong> berhasil dimasukan
                                        </div>";
                                    } else {
                                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        <strong>Data </strong> GAGAL dimasukan
                                        </div>";
                                    }
                                }else { // Username nya kembar
                                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Username $user_cek </strong> sudah ada
                                            </div>";


                                }
                                
                            }
                        }

                        ?>
                        <div class="card mb-4" id="user_list">
                            <div class="card-header">
                                <i class="fa-solid fa-users me-2 text-success fa-fade"></i>
                                Data User
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Telepon</th>
                                            <th>Level</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT username, nama, alamat, kota, telp, level, tipe, status FROM user ORDER BY level ASC");
                                        while($d = mysqli_fetch_row($q)) {
                                            $user = $d[0];
                                            $nama = $d[1];
                                            $alamat = $d[2];
                                            $kota = $d[3];
                                            $telp = $d[4];
                                            $level = $d[5];
                                            $tipe = $d[6];
                                            $status = $d[7];

                                            echo "<tr>
                                                    <td>$user</td>
                                                    <td>$nama</td>
                                                    <td>$alamat</td>
                                                    <td>$kota</td>
                                                    <td>$telp</td>
                                                    <td>$level</td>
                                                    <td>$tipe</td>
                                                    <td>$status</td>
                                                    <td>
                                                        <a href=index.php?p=user_edit&user=$user><button type=\"button\" class=\"btn btn-outline-success btn-sm\">Ubah</button></a>
                                                        <button type=\"button\" class=\"btn btn-outline-danger btn-sm\">Hapus</button>
                                                    </td>  
                                                </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Zaidan Arrifqi 3.33.23.1.24</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../js/air.js"></script>
    </body>
</html>
