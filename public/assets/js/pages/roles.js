function initIndex(){
    $('#tableRoles').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        ajax: getRoles,
        columns: [
            { data: 'id', width:"10%" },
            { data: 'nama',width:"60%" },
            { data: 'action', width:"30%" },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        pageLength: 50,
        bLengthChange: false,
    });

    $("body").on("click",".delete",function(){
        event.preventDefault();
        var id=$(this).attr("data-id");
        var currentRow = $(this).closest("tr");
        let role   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        swal.fire({
            title: 'Are you sure?',
            text: "Anda Akan Menghapus Permission "+role,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: roleDel,
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
        })
    });

    $("body").on("click",".roleShow",function(){
        event.preventDefault();
        console.log("modal click");
        let role_id = $(this).attr("data-val");
        let label = $(this).attr("data-label");
        console.log(label);
        $.ajax({
                    url     : roleShow,
                    type    :'GET',
                    data    : {id:role_id},
                    async   : false,
                    dataType: 'json',
                   success: function(respon) {
                        $('.modal-body').html('');
                        $(".modal-title").html('');
                        $(".modal-title").html("Data Detail Role "+label);
                        if(respon.length){
                            let trHTML = '<div class="col-xs-12 col-sm-12 col-md-12"><div class="row">';
                            let ctrl = 0; let bg= "";
                            $.each(respon, function(key, val) { if(ctrl==4){ctrl=0;}
                                if(ctrl==0){bg = "bg-info";}
                                else if(ctrl==1){bg = "bg-success";}
                                else if(ctrl==2){bg = "bg-warning";}
                                else {bg = "bg-danger";}
                                trHTML += "<div class='col-md-3 mb-2 "+bg+" '>"+val.name+"</div>";

                                //trHTML += '<tr><td>' + val.nim+ '&nbsp;</td><td>&nbsp;' + val.nama + '&nbsp;</td><td>&nbsp;' + val.prodi+ '&nbsp;</td><td>&nbsp;' + val.semester+ '</td></tr>';
                                ctrl++;
                            });
                            trHTML += '</div></div>';
                            console.log(trHTML);
                            $('.modal-body').append(trHTML );
                            $('#showRoles').modal('show');
                        }else{
                            console.log("Belum Ada Responden");
                            swal("Permission Tidak Ditemukan!", "Silahkan Atur Permission Pada Role ini", "error");
                        }
                    }
                });

    });
}

$(function(){
    setTimeout(function(){
        $(".alert-dismissable").slideUp( "slow");
    },3000);
});
