<?php
class klas_air {
    function koneksi() {
        $koneksi=mysqli_connect("localhost", "user_air", "#Us3r_A1r_2025#", "air");
        return $koneksi;
    }

    function dt_user($sesi_user) {
        $q = mysqli_query($this->koneksi(), "SELECT nama, kota, level FROM user WHERE username='$sesi_user'");
        $d = mysqli_fetch_row($q);
        return $d;
    }
    
    function user_to_idtarif($username) {
        $q = mysqli_query($this->koneksi(), "SELECT tipe FROM user WHERE username='$username'");
        $d = mysqli_fetch_row($q);
        $tipe = $d[0];

        $kd_tarif = $this->tipe_to_idtarif($tipe);
        return $kd_tarif;
    }

    function tipe_to_idtarif($tipe) {
        $q = mysqli_query($this->koneksi(), "SELECT kd_tarif FROM tarif WHERE tipe='$tipe'");
        $d = mysqli_fetch_row($q);
        return $d[0];
    }

    function kdtarif_to_tarif($kd_tarif) {
        $q = mysqli_query($this->koneksi(), "SELECT tarif FROM tarif WHERE kd_tarif='$kd_tarif'");
        $d = mysqli_fetch_row($q);
        return $d ? $d[0] : 0; // Kembalikan 0 jika tidak ada data
    }

    function tgl_walik($tgl) {
        $e = explode("-", $tgl);
        $tgl_baru = "$e[2]-$e[1]-$e[0]";
        return $tgl_baru;
    }

    function bln($no) {
        if ($no == 1) $bln = "Januari";
        elseif ($no == 2) $bln = "Februari";
        elseif ($no == 3) $bln = "Maret";
        elseif ($no == 4) $bln = "April";
        elseif ($no == 5) $bln = "Mei";
        elseif ($no == 6) $bln = "Juni";
        elseif ($no == 7) $bln = "Juli";
        elseif ($no == 8) $bln = "Agustus";
        elseif ($no == 9) $bln = "September";
        elseif ($no == 10) $bln = "Oktober";
        elseif ($no == 11) $bln = "November";
        elseif ($no == 12) $bln = "Desember";
        else 
            $bln = "Desember";

            return $bln;
    }
}

?>