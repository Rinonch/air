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
        $("#summary, #chart").hide();
        $("#tarif_list").show();
        $(".datatable-dropdown").append("<button type='button' class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-money-bill-1-wave'></i></button>");

        $(".datatable-dropdown button").click(function () {
            console.log("Tombol tambah diklik!");
            $("#tarif_list").hide();
            $("#tarif_add").show();
        });

        $("button[data-bs-toggle='modal']").click(function () {
            console.log("Tombol hapus di klik");
            const tarif = $(this).attr("data-kd_tarif");
            $("#myModal .modal-body").text("Yakin hapus data tarif: " + tarif);
            $(".modal-footer form").append("<input type='hidden' name='kd_tarif' value='" + tarif + "'>");
        });
    }

    // Logika untuk halaman Tarif Edit
    else if (e[1] && e[1].startsWith("tarif_edit")) {
        $("#tarif_add").show();
        $("#tarif_form button").val("tarif_edit");
        $("#tarif_form input[name='kd_tarif']").attr("disabled", true);

        if (e[2]) {
            $("#tarif_form").append("<input type='hidden' name='kd_tarif' value='" + e[2] + "'>");
        }
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
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
