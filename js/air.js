$(document).ready(function() {
    // Jika javavascript tidak jalan = clear cache

    uri = window.location.href;
    e = uri.split("=");
    console.log("URI: "+uri+" e[1]:"+e[1]+" e[2]:"+e[2]);

    if(e[1] == "user" || e[1] == "user_edit&user") {
        
        $("#summary,#chart, #user_add").hide();
        if(e[1] =="user") {
            // Id summary dan chart disembunyikan
            $("#summary,#chart, #user_add").hide();
        } else {
            $("#summary,#chart, #user_list").hide();
            $("#user_add").show();

            // reset tombol user_add menjadi user_edit
            $("#user_form button").val('user_edit');

            // Mendisable PK
            $("#user_form input[name='username']").attr("disabled", true);

            // Menambahkan elemen input dengan hidden
            $("#user_form").append("<input type='hidden' name='username' value="+e[2]+">");
        }
        // Menyisipkan tombol tambah
        $(".datatable-dropdown").append("<button type=button class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-user-plus'></i> User</button>");
        
        // Membuat tombol bisa klik
        $(".datatable-dropdown button").click(function() {
            // console.log("Tombol tambah diklik!");
            $("#user_list").hide();
            $("#user_add").show();
            $("#user_form input, #user_form textarea").val();
        });
        
    }else {
        // diklik dashboard
        // Id summary dan chart disembunyikan
        $("#summary,#chart").show();
        $("#user_add,#user_list").hide(); 
    }    
})
