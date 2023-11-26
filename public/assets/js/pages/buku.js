function initIndex() {
    table();
    btnEdit();
    Delete();
}

function initEdit() {
    tagSelect();
    fileInputSelect();
    kategoriSelect();
    penerbitAutoComplete();
    tahunPicker();
    $("#tag").val(arrTag).trigger("change");
}

function initAdd() {
    tagSelect();
    kategoriSelect();
    fileInputSelect();
    selectNusantara();
    penerbitAutoComplete();
    tahunPicker();
}
function tahunPicker() {
    $("#tahun").yearpicker({
        year: yearDefault,
        //startYear: 2000,
        endYear: 2050,
    });
}

function penerbitAutoComplete() {
    $(".autocompl-penerbit").autocomplete({
        serviceUrl: getPenerbit,
        paramName: "term",
    });
}

function table() {
    $("#tableUser").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: getBuku,
        columns: [
            { data: "id", width: "8%" },
            { data: "judul", width: "37%" },
            { data: "penerbit", width: "25%" },
            { data: "cover", width: "20%" },
            { data: "action", width: "10%" },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
        },
        pageLength: 50,
        bLengthChange: false,
    });
}

function btnEdit() {
    $("body").on("click", ".btnEditClass", function () {
        event.preventDefault();
        let pageEdit = $(this).attr("data-href");
        console.log(pageEdit);
        $(".tableElement").slideUp("slow", function () {
            window.location.href = pageEdit;
        });
    });
}

function Delete() {
    $("body").on("click", ".delete", function () {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var currentRow = $(this).closest("tr");
        //let buku       = currentRow.find("td:eq(1)").text();  // get current row 2nd TD
        let buku = $(this).attr("data-label");
        console.log(buku);
        swal.fire({
            title: "Hapus Data Buku!!",
            text: "Anda Akan Menghapus Buku " + buku + " ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger ml-2",
            confirmButtonText: "Yes, delete it!",
        }).then(function (result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "POST",
                    url: bukuDelete,
                    data: { id: id, _token: csrf },
                    dataType: "html",
                    success: function (data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success",
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal.fire(
                            "Error deleting!",
                            "Please try again",
                            "error"
                        );
                    },
                });
            }
        });
    });
}

function fileInputSelect() {
    $("#file_buku").fileinput({
        initialPreview: [
            "<img src='" +
                fileBook +
                "' height='160px' class='file-preview-image' alt='' title=''>",
        ],
        resizeImage: true,
        removeClass: "btn btn-warning btn-lg",
        maxImageWidth: 200,
        maxImageHeight: 200,
        resizePreference: "width",
        allowedFileExtensions: ["pdf"],
        previewFileIcon: '<i class="fa fa-file"></i>',
        previewFileType: "pdf",
    });

    $("#file_cover").fileinput({
        initialPreview: [
            "<img src='" +
                fileCover +
                "' height='160px' class='file-preview-image' alt='' title=''>",
        ],
        resizeImage: true,
        removeClass: "btn btn-warning btn-lg",
        maxImageWidth: 200,
        maxImageHeight: 200,
        resizePreference: "width",
    });
}

function selectNusantara() {
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

    $("#SelectProvinsi").change(function () {
        console.log("hi");
        let id = $("#SelectProvinsi").val();
        $.ajax({
            url: NusantaraSelect,
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $("#SelectKabupaten").html("");
                $("#SelectKabupaten").append("<option></option>");
                $.each(response, function (key, value) {
                    $("#SelectKabupaten").append(
                        $("<option></option>")
                            .attr("value", value.id)
                            .text(value.nama)
                    );
                });
            },
        });
    });

    $("#SelectKabupaten").change(function () {
        let id = $("#SelectKabupaten").val();
        console.log(id);
        $.ajax({
            url: NusantaraSelect,
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $("#SelectKecamatan").html("");
                $("#SelectKecamatan").append("<option></option>");
                $.each(response, function (key, value) {
                    $("#SelectKecamatan").append(
                        $("<option></option>")
                            .attr("value", value.id)
                            .text(value.nama)
                    );
                });
            },
        });
    });

    $("#SelectKecamatan").change(function () {
        let id = $("#SelectKecamatan").val();
        $.ajax({
            url: "{{route('NusantaraSelect')}}",
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $("#SelectKelurahan").html("");
                $("#SelectKelurahan").append("<option></option>");
                $.each(response, function (key, value) {
                    $("#SelectKelurahan").append(
                        $("<option></option>")
                            .attr("value", value.id)
                            .text(value.nama)
                    );
                });
            },
        });
    });
}

function tagSelect() {
    $("#tag").select2({
        placeholder: "Pilih Tag",
        allowClear: true,
    });
}

function kategoriSelect() {
    $("#kategori").select2({
        placeholder: "Pilih Kategori",
        allowClear: true,
    });
}

function hanyaAngka(event) {
    var angka = event.which ? event.which : event.keyCode;
    if (angka != 46 && angka > 31 && (angka < 48 || angka > 57)) return false;
    return true;
}

$(function () {
    setTimeout(function () {
        $(".alert-dismissable").slideUp("slow");
    }, 3000);
});
