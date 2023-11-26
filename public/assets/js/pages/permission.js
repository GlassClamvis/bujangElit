function initIndex(){
    initTable();
    initAdd();
    $("#BtnAddPermission").click(function() {
        event.preventDefault();
        $( ".tableElement" ).slideUp( "slow", function() {
            $('.formElementAdd').show( "slow");
            document.getElementById("frmPermission").action = act;
        });
        //$("#btnSubmitAdd").html('Simpan Data Permission');
        //$("#btnCancelAdd").html('Batal Tambah Permission');
    });

    $("#btnCancelAdd").click(function() {
        $( ".formElementAdd" ).slideUp( "slow", function() {
            $('.tableElement').show( "slow");
            document.getElementById("frmPermission").action = act;
        });

        $('.txtPermission').val("");
    });
}


function initTable(){
    $('#tablePermission').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: getPermission,
        columns: [
            { data: 'id', width:"10%" },
            { data: 'nama',width:"60%" },
            { data: 'action', width:"30%" },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        pageLength: 100,
        bLengthChange: false,
    });
}

function initAdd(){
    $("body").on("click",".add-more",function(){
        var html = $(".copy-fields").html();
        var rep=html.replace('display: none;',"display: block;");
        var rep=rep.replace('abc',"input_copy");
        $(".core-ans").append(rep);
        console.log(rep);
    });

        $("body").on("click",".remove",function(){
        $(this).parents(".input_copy").remove();
    });
}

function initEdit(){
    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        var permission = $(this).attr("data-permission");
        let dataUpdate=$(this).attr("data-href");
        $('#permissionUbah').val(permission);
        $( ".tableElement" ).slideUp( "slow", function() {
            $('.formElementEdit').show( "slow");
            document.getElementById("frmPermissionUbah").action = dataUpdate;
        });

        $("#btnSubmit").html('Ubah Data Permission');
        $("#btnCancel").html('Batal Ubah Permission');
    });
}


$("#btnCancel").click(function() {
    $( ".formElementEdit" ).slideUp( "slow", function() {
        $('.tableElement').show( "slow");
        document.getElementById("frmPermission").action = act;
    });

    $('#permission').val("");
});

$(function(){
    setTimeout(function(){
        $(".alert-dismissable").slideUp( "slow");
    },3000);
});

$(function(){
    $("body").on("click",".delete",function(){
        event.preventDefault();
        var id=$(this).attr("data-id");
        var currentRow = $(this).closest("tr");
        let permission   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        swal.fire({
            title: 'Are you sure?',
            text: "Anda Akan Menghapus Permission "+permission,
            icon: 'warning',
            showCancelButton: !0,
            confirmButtonClass:"btn btn-primary w-xs me-2 mt-2",
            cancelButtonClass:"btn btn-danger w-xs mt-2",
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: permissionDelete,
                    data: {id:id, _token: csrf},
                    dataType: "html",
                    success: function (data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        });
    });
});

