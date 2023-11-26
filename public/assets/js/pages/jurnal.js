function initIndex() {
  table();
  checkPlagiaris();
  btnEdit();
  Delete();
  previewCertificate();
  previewStatistik();
}

function initEdit() {
  tagSelect();
  kategoriSelect();
  fileInputSelect();
  penerbitAutoComplete();
  //tahunPicker();
  BaseFlatPicker();
  $("#tag").val(arrTag).trigger("change");
  initAddPengarang();
  reLabelPengarang();
  updateInput();
}

function initAdd() {
  fileInputSelect();
  tagSelect();
  kategoriSelect();
  selectNusantara();
  penerbitAutoComplete();
  BaseFlatPicker();
  initAddPengarang();
}

function BaseFlatPicker() {
  flatpickr.localize(flatpickr.l10ns.id);
  $("#tahunTerbit").flatpickr({
    dateFormat: "d-m-Y",
    placeholder: "Pilih Tahun Terbit",
  });
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
  tableJurnal = $("#tableJurnal").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: getJurnal,
    columns: [
      {
        data: "id",
        width: "8%",
        render: function (data, type, row) {
          return (
            '<div style="width: 100%; white-space: normal;">' + data + "</div>"
          );
        },
      },
      {
        data: "judul",
        width: "37%",
        render: function (data, type, row) {
          return (
            '<div style="width: 100%; white-space: normal;">' + data + "</div>"
          );
        },
      },
      {
        data: "score",
        width: "25%",
        render: function (data, type, row) {
          return (
            '<div style="width: 100%; white-space: normal;">' + data + "</div>"
          );
        },
      },
      {
        data: "cover",
        width: "20%",
        render: function (data, type, row) {
          return (
            '<div style="width: 100%; white-space: normal;">' + data + "</div>"
          );
        },
      },
      {
        data: "action",
        width: "10%",
        render: function (data, type, row) {
          return (
            '<div style="width: 100%; white-space: normal;">' + data + "</div>"
          );
        },
      },
    ],
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search...",
    },
    pageLength: 50,
    bLengthChange: false,
  });
}

function initAddPengarang() {
  $("body").on("click", ".addPengarang", function () {
    var html = $(".copy-pengarang").html();
    var rep = html.replace("btn-success", "btn-danger");
    var rep = rep.replace("addPengarang", "delPengarang");
    var rep = rep.replace("fa-plus", "fa-minus");
    var rep = rep.replace("divCode", "pengarang" + idCodeDiv);
    var rep = rep.replace("idDivCode", "pengarang" + idCodeDiv);
    var rep = rep.replace(
      "labelpengarang-1",
      "labelpengarang-" + (idCodeDiv + 1)
    );
    $(".paste-pengarang").append(rep);
    //console.log(rep);
    reLabelPengarang();
    idCodeDiv += 1;
  });

  $("body").on("click", ".delPengarang", function () {
    var id = $(this).attr("id");
    console.log(id);
    $(this)
      .parents("." + id)
      .remove();
    reLabelPengarang();
  });
}

function reLabelPengarang() {
  let labelId = 1;
  $(".labelPengarang").each(function (i, obj) {
    let id = obj.id;
    $("#" + id).text("Pengarang " + labelId);
    labelId += 1;
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
    let jurnal = $(this).attr("data-label");
    console.log(jurnal);
    swal
      .fire({
        title: "Hapus Data Jurnal!!",
        text: "Anda Akan Menghapus Jurnal " + jurnal + " ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger ml-2",
        confirmButtonText: "Yes, delete it!",
      })
      .then(function (result) {
        if (result.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
          $.ajax({
            type: "POST",
            url: jurnalDelete,
            data: { id: id, _token: csrf },
            dataType: "html",
            success: function (data) {
              swal
                .fire({
                  title: "Hapus Data Berhasil!",
                  text: "",
                  icon: "success",
                })
                .then(function () {
                  location.reload();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
              swal.fire("Error deleting!", "Please try again", "error");
            },
          });
        }
      });
  });
}

function fileInputSelect() {
  $(".fileUpload").fileinput({
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
  });
  /* $("#file_buku").fileinput({
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
  }); */
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
            $("<option></option>").attr("value", value.id).text(value.nama)
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
            $("<option></option>").attr("value", value.id).text(value.nama)
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
            $("<option></option>").attr("value", value.id).text(value.nama)
          );
        });
      },
    });
  });
}

function kategoriSelect() {
  $("#kategori").select2({
    placeholder: "Pilih Kategori",
    allowClear: true,
  });
}

function tagSelect() {
  $("#tag").select2({
    placeholder: "Pilih Tag",
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

function updateInput() {
  /*  $(".updatePengarang").on("blur", function() {
        var inputValue = $(this).data("value");
        let btnId = $(this).data("btnid");
        console.log(btnId);
        $(this).val(inputValue);
        $("#"+btnId).removeClass("btn input-group-text btn-primary waves-effect waves-light SavePengarang").addClass("btn input-group-text btn-danger waves-effect waves-light delPengarangExist");
        $("#"+btnId).find("i").removeClass("fa-paper-plane").addClass("fa-minus");
    }); */

  $("body").on("click", ".delPengarangExist", function () {
    let id = $(this).attr("id");
    let dataSave = $(this).data("save");
    let dataId = $(this).data("id");
    let nama = $("#" + dataSave).data("value");
    swal
      .fire({
        title: "Hapus Data Pengarang!!",
        text: "Anda Akan Menghapus Pengarang " + nama + " ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger ml-2",
        confirmButtonText: "Yes, delete it!",
        reverseButtons: true,
      })
      .then(function (result) {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: delPengarang,
            data: { id: dataId, _token: _token },
            dataType: "html",
            success: function (data) {
              swal
                .fire({
                  title: "Hapus Data Berhasil!",
                  text: "",
                  icon: "success",
                })
                .then(function () {
                  $(this)
                    .parents("." + id)
                    .remove();
                  reLabelPengarang();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
              swal.fire("Error deleting!", "Please try again", "error");
            },
          });
        }
      });

    $(this)
      .parents("." + id)
      .remove();
    reLabelPengarang();
  });

  $("body").on("click", ".SavePengarang", function () {
    let $this = $(this);
    let dataSave = $(this).data("save");
    let id = $(this).data("id");
    let nama = $("#" + dataSave).val();
    $.ajax({
      type: "POST",
      url: updatePengarang,
      data: {
        id: id,
        nama: nama,
        _token: _token,
      },
      dataType: "html",
      beforeSend: function () {
        $this
          .removeClass(
            "btn input-group-text btn-primary waves-effect waves-light SavePengarang"
          )
          .addClass("btn input-group-text btn-info waves-effect waves-light");
        $this
          .find("i")
          .removeClass("fa-paper-plane")
          .addClass("fa-spinner fa-spin");
      },
      success: function (data) {
        swal
          .fire({
            title: "Nama Pengarang Berhasil Diubah",
            text: "",
            icon: "success",
          })
          .then(function () {
            $("#" + dataSave).data("value", nama);
            console.log($this.data("value"));
            $this
              .removeClass(
                "btn input-group-text btn-info waves-effect waves-light"
              )
              .addClass(
                "btn input-group-text btn-danger waves-effect waves-light delPengarangExist"
              );
            $this
              .find("i")
              .removeClass("fa-spinner fa-spin")
              .addClass("fa-minus");
          });
      },
      complete: function () {
        // Set our complete callback, adding the .hidden class and hiding the spinner.
      },
      error: function (xhr, ajaxOptions, thrownError) {
        swal.fire("Update Pengarang Gagal!", "Please try again", "error");
      },
    });
  });

  $(".updatePengarang").on("focus", function () {
    let btnId = $(this).data("btnid");
    let currentId = $(this).prop("id");
    $(".updatePengarang").each(function (i, obj) {
      let id = obj.id;
      let dataBtnId = $(obj).data("btnid");
      let inputValue = $(obj).data("value");
      console.log(inputValue);
      if (id === currentId) {
        $("#" + btnId)
          .removeClass(
            "btn input-group-text btn-danger waves-effect waves-light delPengarangExist"
          )
          .addClass(
            "btn input-group-text btn-primary waves-effect waves-light SavePengarang"
          );
        $("#" + btnId)
          .find("i")
          .removeClass("fa-minus")
          .addClass("fa-paper-plane");
      } else {
        $(obj).val(inputValue);
        $("#" + dataBtnId)
          .removeClass(
            "btn input-group-text btn-primary waves-effect waves-light SavePengarang"
          )
          .addClass(
            "btn input-group-text btn-danger waves-effect waves-light delPengarangExist"
          );
        $("#" + dataBtnId)
          .find("i")
          .removeClass("fa-paper-plane")
          .addClass("fa-minus");
      }
    });
    console.log(btnId);
  });
}

function checkPlagiaris() {
  $("body").on("click", ".btnCheck", function () {
    event.preventDefault();

    let id = $(this).attr("data-href");
    console.log(id);
    $.ajax({
      type: "Get",
      url: JurnaCheck,
      data: { id: id },
      dataType: "html",
      success: function (data) {
        swal
          .fire({
            title: "check Plagiarism Selesai!",
            text: "",
            icon: "success",
          })
          .then(function () {
            tableJurnal.ajax.reload();
            //location.reload();
          });
      },
      error: function (xhr, ajaxOptions, thrownError) {
        swal.fire("Error While Checking!", "Please try again", "error");
      },
    });
  });
}

function previewCertificate() {
  $("body").on("click", ".btnPreview", function () {
    var src = $(this).attr("data-src");
    var label = $(this).attr("data-label");
    console.log(src);
    $("#labelAdm").text(label);
    $("#ifr").attr("src", src);
    $("#FormViewFile").modal("show");
  });
}

function previewStatistik() {
  $("body").on("click", ".btnStatistik", function () {
    var label = $(this).attr("data-label");
    console.log(label);
    $("#labelStatistik").text(label);
    $("#ViewStatistik").modal("show");
  });
}
