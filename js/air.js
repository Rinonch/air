$(document).ready(function () {

    uri = window.location.href;
    e = uri.split("=");
    console.log("URI: "+uri+" e[1]:"+e[1] );

    if(e[1]=="user" || e[1]=="user_edit&user") {
        
        

        if(e[1]=="user") {
            // Menyembunyikan tombol tambah
            $("#summary, #chart, #user_add").hide();
        } else {
            $("#summary, #chart, #user_list").hide();
            $("#user_add").show();
        }
        
        // Menyisipkan tombol tambah
        $(".datatable-dropdown").append("<button type=button class='btn btn-outline-success float-start me-2'><i class='fa-solid fa-user-plus'></i> User</button>");
        // Membuat tombol bisa diklik
        $(".datatable-dropdown button").click(function() {
        //  console.log("tombol diklik");
            $("#user_list").hide();
            $("#user_add").show();
            $("#user_form input, #user_form text-area").val();
        })
    } else {
        // Diklik dashboard 
        // Id summary dan chart disembunyikan
        $("#summary, #chart").show();
        $("#user_add, #user_list").hide();
        
    }

});