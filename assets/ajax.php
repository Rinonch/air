<?php
// Database connection
include '../assets/func.php';
$air = new klas_air;
$koneksi = $air -> koneksi();

if (isset($_POST['p'])) {
    $p = $_POST['p'];

    if ($p == "summary") {
        $bln = $_POST['t'];

        $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jml_pelanggan FROM user WHERE level='warga'");
        $d1 = mysqli_fetch_assoc($q1);
        $data[] = array('jml_pelanggan' => $d1['jml_pelanggan']);

        $q2 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as jml_pemakaian FROM pemakaian WHERE tgl LIKE '$bln%'");
        $d2 = mysqli_fetch_assoc($q2);
        $data[] = array('pemakaian' => $d2['jml_pemakaian']);

        $q3 = mysqli_query($koneksi, "SELECT COUNT(username) as sdh_dicatat FROM pemakaian WHERE tgl LIKE '$bln%'");
        $d3 = mysqli_fetch_assoc($q3);
        $data[] = array('tercatat' => $d3['sdh_dicatat']);

        echo json_encode($data);
    }
}
?>