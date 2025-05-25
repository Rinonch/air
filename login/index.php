<?php
session_start();
if (empty($_SESSION['user']) && empty($_SESSION['pass'])) {
    echo "<script>window.location.replace('../index.php')</script>";
} else {
    //echo "sesi user: " . $_SESSION['user']."sesi pass: ".$_SESSION['pass'];
}

// Database connection
$user = $pass2 = $nama = $alamat = $kota = $telp = $level = $tipe = $status = ""; // Inisialisasi variabel kosong
$kd_tarif = $tarif = $tipe = $status = ""; // Inisialisasi variabel kosong
include '../assets/func.php';
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
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../js/air.js"></script>
    </head>
    <body class="sb-nav-fixed" data-level="<?php echo $level; ?>">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
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
                                <a class="nav-link" href="index.php?p=catat_meter">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Lihat Pemakaian Warga
                                </a>
                                <a class="nav-link" href="index.php?p=manajemen_tarif">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Manajemen Tarif
                                </a>
                            <?php
                            }
                            elseif($level=="bendahara"){
                            ?>
                                <a class="nav-link" href="index.php?p=manajemen_tarif">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Manajemen Tarif
                                </a>
                                <a class="nav-link" href="index.php?p=catat_meter">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                    Lihat Pemakaian Warga
                                </a>
                                <?php
                            }
                            elseif($level=="petugas"){
                                ?>
                                    <a class="nav-link" href="index.php?p=meter_petugas">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Catat Meter
                                    </a>
                                    <?php
                            }
                            elseif($level=="warga"){
                                ?>
                                    <a class="nav-link" href="index.php?p=pemakaian_sendiri">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-spin text-success"></i></div>
                                        Lihat Pemakaian Sendiri
                                    </a>
                                    <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"><i class="fa-regular fa-user fa-flip text-warning"></i> Logged in as: <?php echo $dt_user[2]?> </div>
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
                            } elseif ($e[1] == "pemakaian_sendiri") {
                                $h1 = "Pemakaian & Tagihan Air";
                                $li = "Data Pemakaian & Tagihan Air";
                            } elseif ($e[1] == "manajemen_tarif" || $e[1] == "tarif_edit&kd_tarif") {
                                $h1 = "Lihat Pembayaran Warga";
                                $li = "Lihat Data Pembayaran Air Warga";
                            } elseif ($e[1] == "ubah_datameter_warga") {
                                $h1 = "Ubah Datameter Warga";
                                $li = "Ubah Datameter Air Warga";
                            } elseif ($e[1] == "catat_meter" || $e[1] == "meter_edit&no") {
                                $h1 = "Catat Meteran Warga";
                                $li = "Pencatatatan Meteran Air Warga";
                            }
                            elseif ($e[1] == "meter_petugas") {
                                $h1 = "Pencatatan Meteran";
                                $li = "Pencatatatan Meteran Air Petugas";
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
                        <div class="row mb-3" id="pilih_waktu">
                            <div class="col-xl-3 col-md-12">
                            <label for="sel1" class="form-label">Pilih Waktu:</label>
                            <select class="form-select" id="sel1" name="pilih_waktu">
                            <option value="">Bulan</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i < 10) $i = '0' . $i; // Tambahkan nol di depan untuk bulan 1-9
                                echo "<option value=\"" . date("Y") . "-" . $i . "\">" . $air->bln($i) . " " . date("Y") . "</option>";
                            }
                            ?>
                            </select>
                            </div>
                        </div>
                        <div class="row" id="summary">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body d-flex justify-content-center">
                                        <h1></h1> 
                                        <div class="ms-3"> orang</div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-center">
                                        <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                        <div class="small text-white">Pelanggan</i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body d-flex justify-content-center">
                                        <h1></h1> 
                                        <div class="ms-3">m<sup>3</sup></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-center">
                                        <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                        <div class="small text-white">Pemakaian Air</i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body d-flex justify-content-center">
                                        <h1></h1> 
                                        <div class="ms-3">warga</div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-center">
                                        <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                        <div class="small text-white">Sudah Dicatat</i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body d-flex justify-content-center">
                                        <h1></h1> 
                                        <div class="ms-3">warga</div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-center">
                                        <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                        <div class="small text-white">Belum Dicatat</i></div>
                                    </div>
                                </div>
                            </div>
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
                        <?php
                        if (isset($_POST['tombol'])) {
                            $t = $_POST['tombol'];
                            if ($t == "user_add") {
                                $user = $_POST['username'];
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                $nama = $_POST['nama'];
                                $alamat = $_POST['alamat'];
                                $kota = $_POST['kota'];
                                $telp = $_POST['telp'];
                                $level = $_POST['level'];
                                $tipe = $_POST['tipe'];
                                $status = $_POST['status'];

                                $qc = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$user'");
                                if (mysqli_num_rows($qc) == 0) {
                                    // Insert ke database
                                    $insert = mysqli_query($koneksi, "INSERT INTO user (username, password, nama, alamat, kota, telp, level, tipe, status) VALUES ('$user', '$password', '$nama', '$alamat', '$kota', '$telp', '$level', '$tipe', '$status')");
                                    if ($insert) {
                                        echo "<div class='alert alert-success alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Data</strong> berhasil dimasukkan.
                                            </div>";
                                    } else {
                                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Error:</strong> Gagal memasukkan data.
                                            </div>";
                                    }
                                }
                            } elseif ($t == "user_edit") {
                                $user = $_POST['username'];
                                $password = $_POST['password']; // Password baru dari input
                                $nama = $_POST['nama'];
                                $alamat = $_POST['alamat'];
                                $kota = $_POST['kota'];
                                $telp = $_POST['telp'];
                                $level = $_POST['level'];
                                $tipe = $_POST['tipe'];
                                $status = $_POST['status'];

                                // Cek password yang ada di tabel user
                                $qcp = mysqli_query($koneksi, "SELECT password FROM user WHERE username='$user'");
                                $dcp = mysqli_fetch_row($qcp);
                                $pass_db = $dcp[0]; // Password lama dari database

                                if (password_verify($password, $pass_db)) {
                                    // Tidak ada perubahan password
                                    $update = mysqli_query($koneksi, "UPDATE user SET nama='$nama', alamat='$alamat', kota='$kota', telp='$telp', level='$level', tipe='$tipe', status='$status' WHERE username='$user'");
                                } else {
                                    // Ada perubahan password
                                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                                    $update = mysqli_query($koneksi, "UPDATE user SET password='$password_hashed', nama='$nama', alamat='$alamat', kota='$kota', telp='$telp', level='$level', tipe='$tipe', status='$status' WHERE username='$user'");
                                }

                                // Cek apakah query berhasil dan ada perubahan data
                                if ($update && mysqli_affected_rows($koneksi) > 0) {
                                    echo "<div class='alert alert-success alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> berhasil diubah.
                                        </div>";
                                } else {
                                    echo "<div class='alert alert-primary alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> tidak ada perubahan.
                                        </div>";
                                }
                            } elseif ($t == "user_hapus") {
                                $user = $_POST['username'];
                                // Hapus data user
                                $delete = mysqli_query($koneksi, "DELETE FROM user WHERE username='$user'");
                                if ($delete) {
                                    echo "<div class='alert alert-success alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> berhasil dihapus.
                                        </div>";
                                } else {
                                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> Gagal menghapus data.
                                        </div>";
                                }
                            } elseif ($t == "tarif_add") {
                                $kd_tarif = $_POST['kd_tarif'];
                                $tarif = $_POST['tarif'];
                                $tipe = $_POST['tipe'];
                                $status = $_POST['status'];

                                // Periksa apakah ID Tarif sudah ada di database
                                $qc = mysqli_query($koneksi, "SELECT kd_tarif FROM tarif WHERE kd_tarif='$kd_tarif'");
                                if (mysqli_num_rows($qc) == 0) {
                                    // Insert ke database tarif
                                    $insert = mysqli_query($koneksi, "INSERT INTO tarif (kd_tarif, tarif, tipe, status) VALUES ('$kd_tarif', '$tarif', '$tipe', '$status')");
                                    if ($insert) {
                                        echo "<div class='alert alert-success alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Data</strong> berhasil dimasukkan.
                                            </div>";
                                    } else {
                                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Data</strong> gagal dimasukan.
                                            </div>";
                                    }
                                }
                            } elseif ($t == "tarif_edit") {
                                $kd_tarif = $_POST['kd_tarif'];
                                $tarif = $_POST['tarif'];
                                $tipe = $_POST['tipe'];
                                $status = $_POST['status'];

                                // Update data tarif di database
                                $update = mysqli_query($koneksi, "UPDATE tarif SET tarif='$tarif', tipe='$tipe', status='$status' WHERE kd_tarif='$kd_tarif'");

                                // Cek apakah query berhasil dan ada perubahan data
                                if ($update && mysqli_affected_rows($koneksi) > 0) {
                                    echo "<div class='alert alert-success alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> berhasil diubah.
                                        </div>";
                                } else {
                                    echo "<div class='alert alert-primary alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> tidak ada perubahan.
                                        </div>";
                                }
                            } elseif ($t == "tarif_hapus") {
                                $kd_tarif = $_POST['kd_tarif']; // Ambil ID Tarif dari form
                                $delete = mysqli_query($koneksi, "DELETE FROM tarif WHERE kd_tarif='$kd_tarif'");

                                if ($delete) {
                                    echo "<div class='alert alert-success alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> berhasil dihapus.
                                        </div>";
                                } else {
                                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> gagal dihapus.
                                        </div>";
                                }
                            } elseif ($t == "meter_add") {
                                $username = $_POST['username'];
                                $meter_awal = $_POST['meter_awal'];
                                $meter_akhir = $_POST['meter_akhir'];
                                $kd_tarif = $air->user_to_idtarif($username);
                                $tarif = $air->kdtarif_to_tarif($kd_tarif);
                                $status = isset($_POST['status']) ? $_POST['status'] : 'BELUM LUNAS';

                                $pemakaian = $meter_akhir - $meter_awal;
                                $tagihan = $tarif * $pemakaian;
                                if($pemakaian < 0 ) {
                                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Meter akhir </strong> harus lebih besar dari meter awal.
                                            </div>";
                                }
                                else {
                                    $qc = mysqli_query($koneksi, "SELECT no FROM pemakaian WHERE username='$username' AND tgl=CURRENT_DATE()");
                                    if (mysqli_num_rows($qc) == 0) {
                                        $insert = mysqli_query($koneksi, "INSERT INTO pemakaian (username, meter_awal, meter_akhir, pemakaian, tgl, waktu, kd_tarif, tagihan, status) VALUES ('$username', '$meter_awal', '$meter_akhir', '$pemakaian', CURRENT_DATE(), CURRENT_TIME(), '$kd_tarif', '$tagihan', '$status')");
                                        if ($insert) {
                                            echo "<div class='alert alert-success alert-dismissible fade show' id='alert-meter'>
                                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                    <strong>Data</strong> berhasil dimasukkan.
                                                </div>";
                                        } else {
                                            echo "<div class='alert alert-danger alert-dismissible fade show' id='alert-meter'>
                                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                    <strong>Data</strong> gagal dimasukan.
                                                </div>";
                                        }
                                    }
                                }
                            } elseif ($t == "meter_edit") {
                                $no = $_POST['no'];
                                $meter_awal = $_POST['meter_awal'];
                                $meter_akhir = $_POST['meter_akhir'];
                                $status = isset($_POST['status']) ? $_POST['status'] : 'BELUM LUNAS';

                                $q = mysqli_query($koneksi, "SELECT username, kd_tarif FROM pemakaian WHERE no='$no'");
                                $d = mysqli_fetch_row($q);
                                $username = $d[0];
                                $kd_tarif = $d[1];
                                $tarif = $air->kdtarif_to_tarif($kd_tarif);

                                $pemakaian = $meter_akhir - $meter_awal;
                                $tagihan = $tarif * $pemakaian;

                                if ($pemakaian < 0) {
                                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Meter akhir</strong> harus lebih besar dari meter awal.
                                        </div>";
                                } else {
                                    $update = mysqli_query($koneksi, "UPDATE pemakaian SET meter_awal='$meter_awal', meter_akhir='$meter_akhir', pemakaian='$pemakaian', tagihan='$tagihan', status='$status' WHERE no='$no'");
                                    if ($update) {
                                        echo "<div class='alert alert-success alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Data</strong> berhasil diubah.
                                            </div>";
                                    } else {
                                        echo "<div class='alert alert-danger alert-dismissible fade show'>
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                <strong>Data</strong> gagal diubah.
                                            </div>";
                                    }
                                }
                            } elseif ($t == "meter_hapus") {
                                $no = $_POST['no'];
                                $hapus = mysqli_query($koneksi, "DELETE FROM pemakaian WHERE no='$no'");
                                if ($hapus) {
                                    echo "<div class='alert alert-success alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> berhasil dihapus.
                                        </div>";
                                } else {
                                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Data</strong> gagal dihapus.
                                        </div>";
                                }
                            }
                        } elseif (isset($_GET['p'])) {
                            $p = $_GET['p'];
                            if ($p == "user_edit") {

                                $user = $_GET['user'];
                                // echo "masuk sini untuk edit: $user";
                                $q = mysqli_query($koneksi, "SELECT password, nama, alamat, kota, telp, level, tipe, status FROM user WHERE username='$user'");
                                $d = mysqli_fetch_row($q);
                                $password = $d[0];
                                $pass2 = password_hash($password, PASSWORD_DEFAULT);
                                $nama = $d[1];
                                $alamat = $d[2];
                                $kota = $d[3];
                                $telp = $d[4];
                                $level = $d[5];
                                $tipe = $d[6];
                                $status = $d[7];
                            } elseif ($p == "tarif_edit") {
                                $kd_tarif = $_GET['kd_tarif']; // Ambil kd_tarif dari URL
                                $q = mysqli_query($koneksi, "SELECT tarif, tipe, status FROM tarif WHERE kd_tarif='$kd_tarif'");
                                $d = mysqli_fetch_row($q);

                                if ($d) {
                                    $kd_tarif = $_GET['kd_tarif'];
                                    $tarif = $d[0];
                                    $tipe = $d[1];
                                    $status = $d[2];
                                } else {
                                    $kd_tarif = ""; // Inisialisasi default
                                    $tarif = "";
                                    $tipe = "";
                                    $status = "";
                                }
                            } elseif ($p == "meter_edit") {
                                $no = $_GET['no'];
                                $q = mysqli_query($koneksi, "SELECT username, meter_awal, meter_akhir, status FROM pemakaian WHERE no='$no'");
                                $d = mysqli_fetch_row($q);

                                if ($d) {
                                    $username = $d[0];
                                    $meter_awal = $d[1];
                                    $meter_akhir = $d[2];
                                    $status = $d[3];
                                } else {
                                    $username = "";
                                    $meter_awal = "";
                                    $meter_akhir = "";
                                    $status = "";
                                }
                            }
                        }
                        ?>
                        <?php
                        if (isset($_GET['p']) && $_GET['p'] == "pemakaian_sendiri" && $level == "warga") {
                            $username = $_SESSION['user'];
                            ?>
                            <div class="card mb-4" id="tagihan_sendiri">
                                <div class="card-header">
                                    <i class="fa-solid fa-file-invoice-dollar text-success fa-beat"></i>
                                    Tagihan Air Saya
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Waktu Pencatatan Meter</th>
                                                <th>Kode Tarif</th>
                                                <th>Meter Awal</th>
                                                <th>Meter Akhir</th>
                                                <th>Pemakaian (m<sup>3</sup>)</th>
                                                <th>Tagihan (Rp)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT tgl, waktu, kd_tarif, meter_awal, meter_akhir, pemakaian, tagihan, status FROM pemakaian WHERE username='$username' ORDER BY tgl DESC");
                                        while ($d = mysqli_fetch_row($q)) {
                                            echo "<tr>";
                                            echo "<td>".$air->tgl_walik($d[0])." ".$d[1]."</td>";
                                            echo "<td>".$d[2]."</td>";
                                            echo "<td>".$d[3]."</td>";
                                            echo "<td>".$d[4]."</td>";
                                            echo "<td>".$d[5]."</td>";
                                            echo "<td>".number_format($d[6],0,',','.')."</td>";

                                            // Status dengan badge warna
                                            if (strtoupper($d[7]) == "LUNAS") {
                                                echo "<td><span class='btn btn-success btn-sm'>LUNAS</span></td>";
                                            } else {
                                                echo "<td><span class='btn btn-danger btn-sm'>BELUM LUNAS</span></td>"; 
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="card mb-4" id="tarif_add" style="display: none;">
                            <div class="card-header">
                                <i class="fa-solid fa-user-plus text-success"></i> Tambah Tarif
                            </div>
                            <div class="card-body">
                                <form method="post" id="tarif_form">
                                    <div class="mb-3">
                                        <label for="kd_tarif" class="form-label">ID Tarif:</label>
                                        <input type="text" class="form-control" id="kd_tarif" name="kd_tarif" value="<?php echo $kd_tarif ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tarif" class="form-label">Tarif:</label>
                                        <input type="number" class="form-control" id="tarif" name="tarif" value="<?php echo $tarif ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe:</label>
                                        <select class="form-select" name="tipe">
                                        <option value="Rumah" <?php echo ($tipe == "Rumah") ? "selected" : ""; ?>>Rumah</option>
                                        <option value="Kost" <?php echo ($tipe == "Kost") ? "selected" : ""; ?>>Kost</option>
                                        </select>
                                    </div>
                                    <?php
                                    $st = array("AKTIF", "TIDAK AKTIF");
                                    foreach ($st as $st2) {
                                        if ($status == $st2) $checked = "CHECKED";
                                        else $checked = "";
                                        echo "<div class=\"form-check form-check-inline\">
                                                <input type='radio' class='form-check-input' id='status_$st2' name='status' value='$st2' $checked>
                                                <label class='form-check-label' for='status_$st2'>$st2</label>
                                            </div>";
                                    }
                                    ?>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary" name="tombol" value="tarif_add">Simpan</button>
                                    </div>
                                </form>
                        </div>
                        </div>
                        <div class="card mb-4" id="meter_add" style="display: none;">
                            <div class="card-header">
                                <i class="fa-solid fa-rupiah-sign me-2 text-success fa-fade"></i> Meter
                            </div>
                            <div class="card-body">
                                <form method="post" id="meter_form">
                                    <?php if (isset($_GET['p']) && $_GET['p'] == "meter_edit") { ?>
                                        <input type="hidden" name="no" value="<?php echo htmlspecialchars($_GET['no']); ?>">
                                    <?php } ?>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nama Warga:</label>
                                        <select class="form-select" name="username" required <?php if (isset($_GET['p']) && $_GET['p'] == "meter_edit") echo "disabled"; ?>>
                                            <option value="">Nama Warga</option>
                                            <?php
                                            $qw = mysqli_query($koneksi, "SELECT username, nama FROM user WHERE level='warga'");
                                            while($dw = mysqli_fetch_row($qw)) {
                                                $sel = ($username == $dw[0]) ? "SELECTED" : "";
                                                echo "<option value='$dw[0]' $sel>$dw[1]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meter_awal" class="form-label">Meter Awal (m<sup>3</sup>) :</label>
                                        <input type="text" class="form-control" id="meter_awal" name="meter_awal" value="<?php echo $meter_awal ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meter_akhir" class="form-label">Meter Akhir (m<sup>3</sup>) :</label>
                                        <input type="text" class="form-control" id="meter_akhir" name="meter_akhir" value="<?php echo $meter_akhir ?>" required>
                                    </div>
                                    <div class="mb-3">
                                    <label for="status" class="form-label">Status:</label>
                                    <select class="form-select" name="status">
                                        <option value="">Status</option>
                                        <?php
                                        $s = array("LUNAS", "BELUM LUNAS");
                                        foreach ($s as $s2) {
                                            if ($status == $s2) $sel = "SELECTED";
                                            else $sel = "";
                                            echo "<option value='$s2' $sel>$s2</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary" name="tombol" value="<?php echo (isset($_GET['p']) && $_GET['p'] == "meter_edit") ? "meter_edit" : "meter_add"; ?>">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                        </div>
                        </div>
                        <div class="card mb-4" id="user_add">
                            <div class="card-header">
                                <i class="fa-solid fa-user-plus text-success fa-fade"></i>
                                User
                            </div>
                            <div class="card-body">
                            <form method="post" class="needs-validation" id="user_form">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username:</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo $user ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="<?php echo $password ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama:</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Enter nama" name="nama" value="<?php echo $nama?>" required>
                                </div>
                                <div class="mb-3">
                                <label for="alamat">Alamat:</label>
                                <textarea class="form-control" rows="5" id="alamat" name="alamat"><?php echo $alamat ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota:</label>
                                    <input type="text" class="form-control" id="kota" placeholder="Enter kota" name="kota" value="<?php echo $kota ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="telp" class="form-label">Telepon:</label>
                                    <input type="text" class="form-control" id="telp" placeholder="Enter telp" name="telp" value="<?php echo $telp ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="level" class="form-label">Level:</label>
                                    <select class="form-select" name="level">
                                        <option value="">Level</option>
                                        <?php
                                        $lv = array("admin", "bendahara", "petugas", "warga");
                                        foreach ($lv as $lv2) {
                                            if ($level == $lv2) $sel = "SELECTED";
                                            else $sel = "";
                                            echo "<option value=$lv2 $sel >"  . ucwords($lv2) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe" class="form-label">Tipe:</label>
                                    <select class="form-select" name="tipe">
                                        <option value="">Tipe</option>
                                        <?php
                                        $t = array("Rumah", "Kost");
                                        foreach ($t as $t2) {
                                            if ($tipe == $t2) $sel = "SELECTED";
                                            else $sel = "";
                                            echo "<option value=$t2 $sel>"  . ucwords($t2) . "</option>";
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
                                        foreach ($s as $s2) {
                                            if ($status == $s2) $sel = "SELECTED";
                                            else $sel = "";
                                            echo "<option value='$s2' $sel>$s2</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="tombol" value="user_add">Simpan</button>
                            </form>
                        </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus user <strong id="modal-username"></strong>?
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <form method="post">
                                            <input type="hidden" name="username" id="modal-input-username">
                                            <button type="submit" name="tombol" value="user_hapus" class="btn btn-danger">Ya</button>
                                        </form>
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Hapus Tarif -->
                        <div class="modal fade" id="hapusTarifModal" tabindex="-1" aria-labelledby="hapusTarifModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusTarifModalLabel">Konfirmasi Hapus Tarif</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus tarif <span id="modal-tarif-id"></span> ?
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <form method="post">
                                            <input type="hidden" name="kd_tarif" id="modal-input-tarif-id">
                                            <button type="submit" name="tombol" value="tarif_hapus" class="btn btn-danger">Hapus</button>
                                        </form>
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Hapus Meter -->
                        <div class="modal fade" id="hapusMeterModal" tabindex="-1" aria-labelledby="hapusMeterModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form method="post">
                                <div class="modal-header">
                                <h5 class="modal-title" id="hapusMeterModalLabel">Konfirmasi Hapus Data Meter</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                Apakah Anda yakin ingin menghapus meter <span id="modal-meter-no"></span>?
                                <input type="hidden" name="no" id="modal-input-meter-no">
                                </div>
                                <div class="modal-footer">
                                <button type="submit" name="tombol" value="meter_hapus" class="btn btn-danger">Hapus</button>
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tidak</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                        <div class="card mb-4" id="user_list">
                            <div class="card-header">
                                <i class="fa-solid fa-users text-success fa-fade"></i>
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
                                            <th>Telp</th>
                                            <th>Level</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT username, nama, alamat, kota, telp, level, tipe, status FROM user ORDER BY level ASC");
                                        while ($d = mysqli_fetch_row($q)) {
                                            $user = $d[0];
                                            $nama = $d[1];
                                            $alamat = $d[2];
                                            $kota = $d[3];
                                            $telp = $d[4];
                                            $level = $d[5];
                                            $tipe = $d[6];
                                            $status = $d[7];

                                            echo "<tr>";
                                            echo "<td>$user</td>";
                                            echo "<td>$nama</td>";
                                            echo "<td>$alamat</td>";
                                            echo "<td>$kota</td>";
                                            echo "<td>$telp</td>";
                                            echo "<td>$level</td>";
                                            echo "<td>$tipe</td>";
                                            echo "<td>$status</td>";
                                            echo "<td>
                                                    <a href=index.php?p=user_edit&user=$user><button type=button class='btn btn-outline-success btn-sm'>Ubah</button></a>
<button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#myModal' data-user=$user>Hapus</button>
                                                </td>";
                                            echo "</tr>";
                                        }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4" id="tarif_list">
                            <div class="card-header">
                                <i class="fa-solid fa-users text-success fa-fade"></i>
                                Data Tarif
                            </div>
                            <div class="card-body">
                                <table id="tabel_tarif">
                                    <thead>
                                        <tr>
                                            <th>ID Tarif</th>
                                            <th>Tarif</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT kd_tarif, tarif, tipe, status FROM tarif ORDER BY kd_tarif ASC");
                                        while ($d = mysqli_fetch_row($q)) {
                                            $kd_tarif = $d[0];
                                            $tarif = $d[1];
                                            $tipe = $d[2];
                                            $status = $d[3];

                                            echo "<tr>";
                                            echo "<td>$kd_tarif</td>";
                                            echo "<td>$tarif</td>";
                                            echo "<td>$tipe</td>";
                                            echo "<td>";
                                            if (strtoupper($status) == "AKTIF") {
                                                echo "AKTIF";
                                            } else {
                                                echo "TIDAK AKTIF";
                                            }
                                            echo "</td>";
                                            echo "<td>
                                                    <a href=index.php?p=tarif_edit&kd_tarif=$kd_tarif><button type=button class='btn btn-outline-success btn-sm'>Ubah</button></a>
                                                    <button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#hapusTarifModal' data-tarif='$kd_tarif'>Hapus</button>
                                                </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4" id="meter_list">
                            <div class="card-header">
                                <i class="fa-solid fa-users fa-rupiah-sign me-2 fa-fade"></i>
                                Data Meter Warga
                            </div>
                            <div class="card-body">
                                <table id="tabel_meter" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Warga</th>
                                            <th>Tipe</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Meter Awal (m<sup>3</sup>)</th>
                                            <th>Meter Akhir (m<sup>3</sup>)</th>
                                            <th>Pemakaian (m<sup>3</sup>)</th>
                                            <th>Tagihan (Rp)</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT no, username, meter_awal, meter_akhir, pemakaian, tgl, waktu, status FROM pemakaian ORDER BY tgl DESC, username ASC");
                                        while ($d = mysqli_fetch_row($q)) {
                                            $no = $d[0];
                                            $dt_user2 = $air->dt_user($d[1]);
                                            $nama = $dt_user2[0];
                                            $tipe = $dt_user2[2];
                                            $meter_awal = $d[2];
                                            $meter_akhir = $d[3];
                                            $pemakaian = $d[4];
                                            $tgl = $air->tgl_walik($d[5]);
                                            $waktu = $d[6];
                                            $status = $d[7];
                                            $level_login = $dt_user[2];

                                            // Hitung selisih hari
                                            $tgl_tabel = date_create($d[5]);
                                            $tgl_sekarang = date_create();
                                            $diff = date_diff($tgl_tabel, $tgl_sekarang);
                                            $selisih = $diff->days;

                                            // Ambil tarif sesuai user
                                            $kd_tarif = $air->user_to_idtarif($d[1]);
                                            $tarif = $air->kdtarif_to_tarif($kd_tarif);

                                            echo "<tr>";
                                            echo "<td>$nama</td>";
                                            echo "<td>$tipe</td>";
                                            echo "<td>$tgl $waktu | $selisih hari</td>";
                                            echo "<td>$meter_awal</td>";
                                            echo "<td>$meter_akhir</td>";
                                            echo "<td>$pemakaian</td>";
                                            echo "<td>".number_format($tarif * $pemakaian, 0, ',', '.')."</td>";
                                            echo "<td>";
                                            if (strtoupper($status) == "LUNAS") {
                                                echo "<span class='btn btn-success btn-sm'>LUNAS</span>";
                                            } else {
                                                echo "<span class='btn btn-danger btn-sm'>BELUM LUNAS</span>";
                                            }
                                            echo "</td>";

                                            // Tombol aksi
                                            if($level_login == "admin" || $level_login == "bendahara") {
                                                echo "<td>
                                                    <a href='index.php?p=meter_edit&no=$no'><button type='button' class='btn btn-outline-success btn-sm'>Ubah</button></a>
                                                    <button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#hapusMeterModal' data-no='$no'>Hapus</button>
                                                </td>";
                                            } else {
                                                if($selisih <= 30) {
                                                    echo "<td>
                                                        <a href='index.php?p=meter_edit&no=$no'><button type='button' class='btn btn-outline-success btn-sm'>Ubah</button></a>
                                                        <button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#hapusMeterModal' data-no='$no'>Hapus</button>
                                                    </td>";
                                                } else {
                                                    echo "<td></td>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4" id="meter_petugas">
                            <div class="card-header">
                                <i class="fa-solid fa-users fa-rupiah-sign me-2 fa-fade"></i>
                                Data Meter Warga
                            </div>
                            <div class="card-body">
                                <table id="tabel_meter_petugas">
                                    <thead>
                                        <tr>
                                            <th>Nama Warga</th>
                                            <th>Tipe</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Meter Awal (m<sup>3</sup>)</th>
                                            <th>Meter Akhir (m<sup>3</sup>)</th>
                                            <th>Pemakaian (m<sup>3</sup>)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query($koneksi, "SELECT no, username, meter_awal, meter_akhir, pemakaian, tgl, waktu FROM pemakaian ORDER BY tgl DESC, username ASC");
                                        while ($d = mysqli_fetch_row($q)) {
                                            $no = $d[0];
                                            $dt_user2 = $air->dt_user($d[1]);
                                            $nama = $dt_user2[0];
                                            $tipe = $dt_user2[2];
                                            $meter_awal = $d[2];
                                            $meter_akhir = $d[3];
                                            $pemakaian = $d[4];
                                            $tgl = $air->tgl_walik($d[5]);
                                            $waktu = $d[6];

                                            $tgl_tabel = date_create($d[5]);
                                            $tgl_sekarang = date_create();
                                            $diff = date_diff($tgl_tabel, $tgl_sekarang);
                                            $selisih = $diff->days;

                                            echo "<tr>";
                                            echo "<td>$nama</td>";
                                            echo "<td>$tipe</td>";
                                            echo "<td>$tgl $waktu | $selisih hari</td>";
                                            echo "<td>$meter_awal</td>";
                                            echo "<td>$meter_akhir</td>";
                                            echo "<td>$pemakaian</td>";
                                            echo "</tr>";
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
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
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
    </body>
</html>
