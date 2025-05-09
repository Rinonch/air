$(document).ready(function () {
    // Ambil URI dan pecah menjadi array
    const uri = window.location.href;
    const e = uri.split("=");
    console.log("URI: " + uri + " e[1]: " + (e[1] || "undefined") + " e[2]: " + (e[2] || "undefined"));

    // Sembunyikan semua elemen terlebih dahulu
    $("#user_add, #user_list, #tarif_add, #tarif_list").hide();

    // Logika untuk halaman Manajemen User
    if (e[1] === "user" || e[1] === "user_edit&user") {
        $("#user_list").show();

        if (e[1] === "user") {
            $("#summary, #chart").hide();
        } else {
            $("#summary, #chart, #user_list").hide();
            $("#user_add").show();
            $("#user_form button").val("user_edit");
            $("#user_form input[name='username']").attr("disabled", true);

            if (e[2]) {
                $("#user_form").append("<input type='hidden' name='username' value='" + e[2] + "'>");
            }
        }

        $(".datatable-dropdown").append("<button type='button' class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-user-plus'></i> User</button>");
        $(".datatable-dropdown button").click(function () {
            console.log("Tombol tambah diklik!");
            $("#user_list").hide();
            $("#user_add").show();
            $("#user_form input, #user_form textarea").val("");
        });

        $("button[data-bs-toggle='modal']").click(function () {
            console.log("Tombol hapus diklik!");
            const user = $(this).attr("data-user");
            $("#myModal .modal-body").text("Yakin hapus data username: " + user + " ?");
            $(".modal-footer form").append("<input type='hidden' name='username' value='" + user + "'>");
        });
    }

    // Logika untuk halaman Pembayaran Warga
    else if (e[1] === "pembayaran_warga") {
        $("#tarif_add").hide(); // Sembunyikan form tambah tarif
        $("#tarif_list").show(); // Tampilkan tabel tarif
        $("#summary, #chart").hide(); // Sembunyikan elemen summary dan chart

        $(".datatable-dropdown").append("<button type='button' class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-money-bill-1-wave'></i> Tambah Tarif</button>");

        // Event untuk tombol Tambah Tarif
        $(".datatable-dropdown button").click(function () {
            console.log("Tombol tambah diklik!");
            $("#tarif_list").hide();
            $("#tarif_add").show();
        });
    }

    // Logika untuk halaman Tarif Edit
    else if (e[1] && e[1].startsWith("tarif_edit")) {
        $("#tarif_add").show(); // Tampilkan form tambah/edit tarif
        $("#tarif_list").hide(); // Sembunyikan tabel tarif
        $("#summary, #chart").hide(); // Sembunyikan elemen summary dan chart
        $("#tarif_form button").val("tarif_edit");
        $("#tarif_form input[name='kd_tarif']").attr("disabled", true);

        if (e[2]) {
            $("#tarif_form").append("<input type='hidden' name='kd_tarif' value='" + e[2] + "'>");
        }
    }

    // Logika untuk halaman Catat Meter
    else if (e[1] === "catat_meter") {
        // Sembunyikan summary dan chart
        $("#summary, #chart").hide();

        // Tampilkan form catat meter jika ada
        $("#meter_form").show();

        // Jika ada tabel data catat meter, bisa ditampilkan juga
        $("#meter_list").show();

        // Tambahan: reset form jika tombol tambah diklik
        $(".btn-catat-meter-add").click(function () {
            $("#catat_meter_form input, #catat_meter_form textarea").val("");
            $("#catat_meter_form").show();
            $("#catat_meter_list").hide();
        });

        // Tambahan: kembali ke list
        $(".btn-catat-meter-cancel").click(function () {
            $("#catat_meter_form").hide();
            $("#catat_meter_list").show();
        });

        // Inisialisasi DataTables
        const datatablesSimple = document.getElementById('tabel_meter');
        if (datatablesSimple) {
        const dataTable = new simpleDatatables.DataTable(datatablesSimple);
    }
    }

    // Tambahkan setelah proses submit atau setelah alert meter muncul
    if ($("#alert-meter").hasClass("alert-danger")) { // jika saat entri data ada error
        $("#meter_list").hide();
        $("#meter_add").show();
    } else if ($("#alert-meter").hasClass("alert-success")) {
        $("#meter_list").show();
        $("#meter_add").hide();
    }

    // Tombol Simpan untuk Tarif
    $("#btn-simpan").click(function () {
        $("#tarif_add").hide();
        $("#tarif_list").show();
        $("#alert-success").fadeIn().delay(2000).fadeOut();
    });

    // Inisialisasi DataTables
    const datatablesSimple = document.getElementById('tabel_tarif');
    if (datatablesSimple) {
        const dataTable = new simpleDatatables.DataTable(datatablesSimple);

        // Tambahkan tombol Tarif setelah DataTables selesai diinisialisasi
        dataTable.on('datatable.init', function () {
            if (e[1] !== "user") { // Hanya tambahkan tombol Tarif jika bukan di halaman Data User
                $(".datatable-dropdown").prepend("<button type='button' class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-money-bill-1-wave'></i> Tarif</button>");
            }
        });

        // Tambahkan tombol Meter setelah DataTables selesai diinisialisasi
        dataTable.on('datatable.init', function () {
            if (e[1] === "catat_meter") { // Khusus untuk halaman Catat Meter
                // Hilangkan tombol Tarif jika ada
                $(".btn-outline-success:contains('Tarif')").remove();
                // Tambahkan tombol Meter jika belum ada
                if ($(".btn-catat-meter").length === 0) {
                    $(".datatable-dropdown").prepend(
                        "<button type='button' class='btn btn-outline-success float-start me-2 btn-catat-meter'><i class='fa-solid fa-square-plus'></i> Meter</button>"
                    );
                }
            }
        });
    }

    // Tombol Tarif untuk menampilkan form tambah tarif
    $(document).on("click", ".btn-outline-success", function () {
        // console.log("Tombol Tarif diklik!");
        if (e[1] !== "user") {
        $("#tarif_list").hide();
        $("#tarif_add").show();
    }
    });

    $(document).on("click", "button[data-bs-target='#hapusTarifModal']", function () {
        const kd_tarif = $(this).data("tarif");
        $("#modal-tarif-id").text(kd_tarif); // Tampilkan ID Tarif di modal
        $("#modal-input-tarif-id").val(kd_tarif); // Set nilai input hidden untuk form
    });

    // Tombol Meter untuk menampilkan form tambah meter (khusus catat_meter)
    $(document).on("click", ".btn-catat-meter", function () {
        // Reset form input dan textarea
        $("#meter_form input, #meter_form textarea").val("");
        // Tampilkan form catat meter
        $("#meter_form").show();
        // Sembunyikan list catat meter
        $("#meter_list, #tarif_add").hide();
        // Tampilkan meter add
        $("#meter_add").show();
        
    });
});
