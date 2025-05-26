<?php
// Database connection
include '../assets/func.php';
$air = new klas_air;
$koneksi = $air -> koneksi();

if (isset($_POST['p'])) {
    $p = $_POST['p'];

    if ($p == "summary_bendahara") {
        $bln = $_POST['t'];

        // Total payers (customers)
        $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as total_payers FROM user WHERE level='warga'");
        $d1 = mysqli_fetch_assoc($q1);

        // Total income (sum of payments) for the month
        $q2 = mysqli_query($koneksi, "SELECT SUM(pemakaian * tarif) as total_income FROM pemakaian JOIN tarif ON pemakaian.kd_tarif = tarif.kd_tarif WHERE tgl LIKE '$bln%'");
        $d2 = mysqli_fetch_assoc($q2);

        // Fully paid count for the month
        $q3 = mysqli_query($koneksi, "SELECT COUNT(username) as fully_paid FROM pemakaian WHERE tgl LIKE '$bln%' AND status = 'lunas'");
        $d3 = mysqli_fetch_assoc($q3);

        // Unpaid count for the month
        $q4 = mysqli_query($koneksi, "SELECT COUNT(username) as unpaid FROM pemakaian WHERE tgl LIKE '$bln%' AND status != 'lunas'");
        $d4 = mysqli_fetch_assoc($q4);

        $data = array(
            'total_payers' => intval($d1['total_payers']),
            'total_income' => floatval($d2['total_income']),
            'fully_paid' => intval($d3['fully_paid']),
            'unpaid' => intval($d4['unpaid'])
        );

        echo json_encode($data);
    }
}
?>
