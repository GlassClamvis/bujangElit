function initIndex(){
    initTable();
    initAdd();
    $("#BtnAddKategori").click(function() {
        event.preventDefault();
        $( ".tableElement" ).slideUp( "slow", function() {
            $('.formElementAdd').show( "slow");
            document.getElementById("frmKategori").action = act;
        });
        //$("#btnSubmitAdd").html('Simpan Data Kategori');
        //$("#btnCancelAdd").html('Batal Tambah Katergori');
    });

    $("#btnCancelAdd").click(function() {
        $( ".formElementAdd" ).slideUp( "slow", function() {
            $('.tableElement').show( "slow");
            document.getElementById("frmKategori").action = act;
        });

        $('.txtKategori').val("");
    });
}

function initTable(){
    $('#tableKategori').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: getKategori,
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
        var kategori = $(this).attr("data-kategori");
        let dataUpdate=$(this).attr("data-href");
        $('#kategoriUbah').val(kategori);
        $( ".tableElement" ).slideUp( "slow", function() {
            $('.formElementEdit').show( "slow");
            document.getElementById("frmKategoriUbah").action = dataUpdate;
        });

        $("#btnSubmit").html('Ubah Data Kategori');
        $("#btnCancel").html('Batal Ubah Kategori');
    });
}


$("#btnCancel").click(function() {
    $( ".formElementEdit" ).slideUp( "slow", function() {
        $('.tableElement').show( "slow");
        document.getElementById("frmKategori").action = act;
    });

    $('#kategori').val("");
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
        let kategori   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        swal.fire({
            title: 'Are you sure?',
            text: "Anda Akan Menghapus Kategori "+kategori,
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
                    url: kategoriDelete,
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

