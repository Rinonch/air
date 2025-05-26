<?php
session_start();
// Database connection
include '../assets/func.php';
$air = new klas_air;
$koneksi = $air -> koneksi();

if (isset($_POST['p'])) {
    $p = $_POST['p'];

    if ($p == "summary_warga") {
        $bln = $_POST['t'];
        $username = $_SESSION['user'];

        // Latest recording time for warga in the month - extract month only, filter by username
        $q1 = mysqli_query($koneksi, "SELECT DATE_FORMAT(MAX(tgl), '%d') as waktu_pencatatan FROM pemakaian WHERE tgl LIKE '$bln%' AND username = '$username'");
        $d1 = mysqli_fetch_assoc($q1);

        // Total water usage in the month, filter by username
        $q2 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as pemakaian_air FROM pemakaian WHERE tgl LIKE '$bln%' AND username = '$username'");
        $d2 = mysqli_fetch_assoc($q2);

        // Total bill amount in the month, filter by username
        $q3 = mysqli_query($koneksi, "SELECT SUM(tagihan) as total_tagihan FROM pemakaian WHERE tgl LIKE '$bln%' AND username = '$username'");
        $d3 = mysqli_fetch_assoc($q3);

        // Bill payment status summary (count of paid bills), filter by username
        $q4 = mysqli_query($koneksi, "SELECT COUNT(*) as lunas_count FROM pemakaian WHERE tgl LIKE '$bln%' AND status = 'lunas' AND username = '$username'");
        $d4 = mysqli_fetch_assoc($q4);

        $data = array(
            'waktu_pencatatan' => $d1['waktu_pencatatan'] ?? '',
            'pemakaian_air' => intval($d2['pemakaian_air']),
            'total_tagihan' => intval($d3['total_tagihan']),
            'status_tagihan' => $d4['lunas_count'] > 0 ? 'LUNAS' : 'BELUM LUNAS'
        );

        echo json_encode($data);
    }
}
?>
