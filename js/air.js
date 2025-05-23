$(document).ready(function () {
    // Ambil URI dan pecah menjadi array
    const uri = window.location.href;
    const e = uri.split("=");
    console.log("URI: " + uri + " e[1]: " + (e[1] || "undefined") + " e[2]: " + (e[2] || "undefined"));

    // Sembunyikan meter_list di semua halaman kecuali catat_meter
    if (e[1] !== "catat_meter") {
        $("#meter_list").hide();
    }

    // Sembunyikan semua elemen terlebih dahulu
    $("#user_add, #user_list, #tarif_add, #tarif_list, #meter_petugas").hide();

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

$(document).ready(function () {
    // ... existing code ...

    // Updated delete user button click handler
    $(document).on("click", "button.btn-outline-danger[data-bs-target='#myModal'][data-user]", function () {
        const user = $(this).attr("data-user");
        $("#modal-username").text(user);
        $("#modal-input-username").val(user);
    });

    // ... existing code ...
});
    }

    // Logika untuk halaman Pemakaian Sendiri Warga
    else if (e[1] === "pemakaian_sendiri") {
        $("#tagihan_sendiri").show(); // Tampilkan tabel tarif
        $("#summary, #chart").hide(); // Sembunyikan elemen summary dan chart
    }

    // Logika untuk halaman Manajemen Tarif
    else if (e[1] === "manajemen_tarif") {
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

        // Ambil level user dari atribut body
        var level_login = $("body").data("level");

        // Inisialisasi DataTables pada tabel meter
        const datatablesSimple = document.getElementById('tabel_meter');
        if (datatablesSimple) {
            const dataTable = new simpleDatatables.DataTable(datatablesSimple);

            dataTable.on('datatable.init', function () {
                // Tampilkan tombol Meter hanya untuk admin
                if (level_login === "admin") {
                    // Hilangkan tombol Meter jika sudah ada
                    $(".btn-catat-meter-add").remove();
                    $(".datatable-dropdown").prepend(
                        "<button type='button' class='btn btn-outline-success float-start me-2 btn-catat-meter-add'><i class='fa-solid fa-square-plus'></i> Meter</button>"
                    );
                }
            });
        }

        // Event tombol tambah meter
        $(document).on("click", ".btn-catat-meter-add", function () {
            $("#meter_add input, #meter_add textarea").val(""); // Kosongkan input di meter_add
            $("#meter_add").show();         // Tampilkan form tambah meter
            $("#meter_list").hide();        // Sembunyikan daftar meter
            $("#catat_meter_form").hide();  // Sembunyikan form lama jika ada
            $("#meter_petugas").hide();     // Sembunyikan form petugas jika ada
        });

        // Event tombol batal tambah meter
        $(document).on("click", ".btn-catat-meter-cancel", function () {
            $("#catat_meter_form").hide();
            $("#catat_meter_list").show();
        });
    }

    // Logika untuk halaman Catat Meter atau Edit Meter
    else if (e[1] === "catat_meter" || e[1] === "meter_edit&no") {
        // Sembunyikan semua elemen utama
        $("#summary, #chart, #user_add, #user_list, #tarif_add, #tarif_list").hide();

        if (e[1] === "catat_meter") {
            // Sembunyikan summary dan chart, tampilkan form tambah meter
            $("#meter_add").hide();
            $("#meter_list").show();
        } else {
            // Untuk halaman edit meter
            console.log("aksi meter_edit");
            $("#summary, #chart, #meter_list").hide();
            $("#meter_add").show();

            // Reset value tombol submit jadi meter_edit
            $("#meter_form button").val("meter_edit");

            // Disable primary key username
            $("#meter_form select[name='username']").attr("disabled", true);

            // Tambahkan elemen input hidden untuk no (ID meter)
            if (e[2] && $("#meter_form input[name='no']").length === 0) {
                $("#meter_form").append("<input type='hidden' name='no' value='" + e[2] + "'>");
            }
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
            if (e[1] === "manajemen_tarif") {
                $(".datatable-dropdown").prepend("<button type='button' class='btn btn-outline-success float-start me-2 btn-tambah-tarif'><i class='fa-solid fa-money-bill-1-wave'></i> Tarif</button>");
            }
        });
    }

    // Tombol Tarif untuk menampilkan form tambah tarif
    $(document).on("click", ".btn-tambah-tarif", function () {
        $("#tarif_list").hide();
        $("#tarif_add").show();
    });

    // Tombol Meter untuk menampilkan form tambah meter (khusus admin di catat_meter)
    $(document).on("click", ".btn-catat-meter-add", function () {
        $("#catat_meter_form input, #catat_meter_form textarea").val("");
        $("#catat_meter_form").show();
        $("#catat_meter_list").hide();
        $("#meter_list").hide();
        $("#meter_petugas").hide();
    });


    $(document).on("click", "button[data-bs-target='#hapusTarifModal']", function () {
        const kd_tarif = $(this).data("tarif");
        $("#modal-tarif-id").text(kd_tarif); // Tampilkan ID Tarif di modal
        $("#modal-input-tarif-id").val(kd_tarif); // Set nilai input hidden untuk form
    });


    $(document).on("click", "button[data-bs-target='#hapusMeterModal']", function () {
        const no = $(this).data("no");
        $("#modal-meter-no").text(no);
        $("#modal-input-meter-no").val(no);
    });

    // Logika untuk halaman Meter Petugas
    if (e[1] === "meter_petugas") {
        // Sembunyikan elemen lain
        $("#tarif_add, #tarif_list, #summary, #chart, #meter_list, #meter_add, #meter_form").hide();

        // Tampilkan tabel khusus petugas
        $("#meter_petugas").show();

        // Inisialisasi DataTables pada tabel petugas
        const datatablesPetugas = document.getElementById('tabel_meter_petugas');
        if (datatablesPetugas) {
            const dataTable = new simpleDatatables.DataTable(datatablesPetugas);

            // Tambahkan tombol Meter setelah DataTables selesai diinisialisasi
            dataTable.on('datatable.init', function () {
                // Hilangkan tombol Meter jika sudah ada
                $(".btn-catat-meter-petugas").remove();
                // Hilangkan tombol Tarif jika ada
                $(".btn-outline-success:contains('Tarif')").remove();
                // Tambahkan tombol Meter jika belum ada
                $(".datatable-dropdown").prepend(
                    "<button type='button' class='btn btn-outline-success float-start me-2 btn-catat-meter-petugas'><i class='fa-solid fa-square-plus'></i> Meter</button>"
                );
            });
        }

        // Event tombol tambah meter (jika ada form input)
        $(document).on("click", ".btn-catat-meter-petugas", function () {
            $("#meter_form input, #meter_form textarea").val("");
            $("#meter_form").show();
            $("#meter_petugas, #tarif_add").hide();
            $("#meter_add").show();
        });

        // Event tombol batal tambah meter (jika ada)
        $(document).on("click", ".btn-catat-meter-cancel", function () {
            $("#meter_form").hide();
            $("#meter_petugas").show();
            $("#meter_add").hide();
        });
    }
});