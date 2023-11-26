function initIndex(){
    table();
    btnEdit();
    Delete();
}

function initEdit(){
    roleSelect();
    fileInputSelect();
    $('#password_confirmation').bind('keyup', cekPassword);
    $('#roles').val(arrRoles).trigger('change');
    console.log(arrRoles);
}

function initEditS(){
    roleSelect();
    fileInputSelect();
    $('#password_confirmation').bind('keyup', cekPassword);
    $('#roles').val(arrRoles).trigger('change');
    //console.log(arrRoles);
    $("#jabfung").select2({
        placeholder: "Pilih Jabatan Fungsional",
        allowClear: true,
    });
    $("#bilmu").select2({
        placeholder: "Pilih Bidang Keahlian",
        allowClear: true,
    });

    $('.decimal').inputNumberFormat({
        'decimal': 2,
        'decimalAuto': 2,
        allowNegative:false
    });

    $("body").on("click","#btnSubmit",function(event){
        event.preventDefault();
        const myForm = document.getElementById('frmStaffEdit');
        let jabfung = $('#jabfung option:selected').text();
        let bilmu = $('#bilmu option:selected').text();
        let angka_kredit = parseFloat($('#angka_kredit').val());
        if(!jabfung){
            swal.fire("Belum Dipilih!", "Jabatan Fungsional Belum Dipilih, Silahkan memilih Jabfung Untuk Melanjutkan", "error");
            return false;
        }
        if(!bilmu){
            swal.fire("Belum Dipilih!", "Bidang Ilmu Belum Dipilih, Silahkan Memilih Untuk Melanjutkan", "error");
            return false;
        }
        let expJabfung = jabfung.split(" | ");
        let range = expJabfung[3];
        console.log(range);
        let expRange = range.split(" - ");
        let awal = parseFloat(expRange[0]);let akhir = parseFloat(expRange[1]);
        console.log(expRange);

        if(angka_kredit >= awal && angka_kredit <= akhir){
            //console.log("this");
            myForm.submit();
        }else{
            swal.fire("Out Of Range!", "Angka Kredit diluar nilai dari jabatan fungsional yang dipilih", "error");
            $('#angka_kredit').focus();
            return false;
        }
    });
}

function initAdd() {
    fileInputSelect();
    selectNusantara();
}


function table(){
    $('#tableUser').DataTable({
        responsive:true,
        processing: true,
        serverSide: true,
        ajax: getPenerbit,
        columns: [
            { data: 'id' },
            { data: 'nama' },
            { data: 'email' },
            { data: 'foto'  },
            { data: 'action' },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        pageLength: 50,
        bLengthChange: false,
    });
}

function btnEdit(){
    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        console.log(pageEdit);
        $( ".tableElement" ).slideUp( "slow", function() {
            window.location.href = pageEdit;
        });
    });
}

function Delete(){
    $("body").on("click",".delete",function(){
        event.preventDefault();
        var id=$(this).attr("data-id");
        var currentRow = $(this).closest("tr");
        let penerbit   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
        swal.fire({
            title: 'Hapus Data Penerbit!!',
            text: "Anda Akan Menghapus Penerbit "+penerbit+" ?",
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
                    url: penerbitDelete,
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
}

function fileInputSelect(){
    $("#foto").fileinput({
        initialPreview: [
			"<img src='"+pathFoto+"' height='160px' class='file-preview-image' alt='' title=''>"
		],
		resizeImage: true,
        removeClass: "btn btn-warning btn-lg",
		maxImageWidth: 200,
		maxImageHeight: 200,
		resizePreference: 'width'
	});
}

function selectNusantara(){
    $("#SelectProvinsi").select2({
        placeholder: "Pilih Provinsi",
        allowClear: true,

    });

    $("#SelectKabupaten").select2({
        placeholder: "Pilih Kabupaten",
        allowClear: true,

    });

    $("#SelectKecamatan").select2({
        placeholder: "Pilih Kecamatan",
        allowClear: true,

    });

    $("#SelectKelurahan").select2({
        placeholder: "Pilih Kelurahan",
        allowClear: true,

    });

    $( "#SelectProvinsi").change(function() {
        console.log("hi");
        let id = $("#SelectProvinsi").val();
      	$.ajax({
            url : NusantaraSelect,
            type:'GET',
            data:{
                id:id
            },
            dataType: 'json',
            success: function(response) {
                $('#SelectKabupaten').html('');
                $('#SelectKabupaten').append('<option></option>');
                $.each(response,function(key, value){
                    $("#SelectKabupaten").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
             }
        });
    });

    $( "#SelectKabupaten").change(function() {
        let id = $("#SelectKabupaten").val();
        console.log(id);
      	$.ajax({
            url : NusantaraSelect,
            type:'GET',
            data:{
                id:id
            },
            dataType: 'json',
            success: function(response) {
                $('#SelectKecamatan').html('');
                $('#SelectKecamatan').append('<option></option>');
                $.each(response,function(key, value){
                    $("#SelectKecamatan").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
             }
        });
    });

    $( "#SelectKecamatan").change(function() {
        let id = $("#SelectKecamatan").val();
      	$.ajax({
            url : "{{route('NusantaraSelect')}}",
            type:'GET',
            data:{
                id:id
            },
            dataType: 'json',
            success: function(response) {
                $('#SelectKelurahan').html('');
                $('#SelectKelurahan').append('<option></option>');
                $.each(response,function(key, value){
                    $("#SelectKelurahan").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
             }
        });
    });
}

function hanyaAngka(event) {
    var angka = (event.which) ? event.which : event.keyCode
    if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
    return true;
}


$(function(){
    setTimeout(function(){
        $(".alert-dismissable").slideUp( "slow");
    },3000);
});


