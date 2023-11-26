function IndexUnit() {
  //tableUnit();
  btnAddUnit();
  //tableUnit.ajax.reload();
  tableUnit = $("#tableUnit").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: getUnit,
    columns: [
      { data: "id" },
      { data: "kode" },
      { data: "unit" },
      /*  { data: 'kajur' }, */
      /* { data: 'is_aktif' }, */
      { data: "action" },
    ],
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search...",
    },
    pageLength: 50,
    bLengthChange: false,
  });
  $("#btnSubmit").click(function () {
    let kode_unit = $("#kodeunit").val();
    let unit = $("#unit").val();
    let metod = $("#metod").val();
    let linkUpdate = $("#linkUpdate").val();
    console.log(linkUpdate);
    if (metod == "PUT") {
      $.ajax({
        method: "POST",
        url: linkUpdate,
        data: {
          kode_unit: kode_unit,
          unit: unit,
          _method: "PUT",
          _token: token,
        },
        dataType: "json",
        success: function (data) {
          $(".formElement").slideUp("slow", function () {
            $(".tableElement").show("slow");
            tableUnit.ajax.reload();
          });
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal.fire(
            "Terjadi Kesalahaan pada saat muat halaman!",
            "Please try again",
            "error"
          );
        },
      });
    } else {
      $.ajax({
        method: "POST",
        url: linkUpdate,
        data: {
          kode_unit: kode_unit,
          unit: unit,
          /* _method: "PUT", */
          _token: token,
        },
        dataType: "json",
        success: function (data) {
          $(".formElement").slideUp("slow", function () {
            $(".tableElement").show("slow");
            tableUnit.ajax.reload();
          });
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal.fire(
            "Terjadi Kesalahaan pada saat muat halaman!",
            "Please try again",
            "error"
          );
        },
      });
    }
  });
}

function tableUnit() {
  tableUnit = $("#tableUnit").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: getUnit,
    columns: [
      { data: "id" },
      { data: "kode" },
      { data: "unit" },
      /*  { data: 'kajur' }, */
      /* { data: 'is_aktif' }, */
      { data: "action" },
    ],
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search...",
    },
    pageLength: 50,
    bLengthChange: false,
  });
}

function btnAddUnit() {
  $("#BtnAddUnit").click(function () {
    event.preventDefault();
    $(".tableElement").slideUp("slow", function () {
      $(".formElement").show("slow");
      document.getElementById("frmUnit").action = act;
      $("#linkUpdate").val(act);
    });
    $("#btnSubmit").html("Simpan Data Unit");
    $("#btnCancel").html("Batal Tambah Unit");
    //console.log(urlProdi);
  });
}

$(".tableElementProdi").hide("slide", { direction: "up" }, 900);

$("#btnCancel").click(function () {
  $(".formElement").slideUp("slow", function () {
    $(".tableElement").show("slow");
  });

  $("#kodejurusan").val("");
  $("#jurusan").val("");
});

$("body").on("click", ".btnEditClass", function () {
  event.preventDefault();
  var kode = $(this).attr("data-kode");
  var unit = $(this).attr("data-unit");

  let dataUpdate = $(this).attr("data-update");

  $("#kodeunit").val(kode);
  $("#unit").val(unit);
  $("#linkUpdate").val(dataUpdate);

  $("#metod").val("PUT");
  var act = dataUpdate;
  $(".tableElement").slideUp("slow", function () {
    $(".formElement").show("slow");
    document.getElementById("frmUnit").action = act;
  });

  $("#btnSubmit").html("Ubah Data Unit");
  $("#btnCancel").html("Batal Ubah Unit");
});

$("body").on("click", ".btnDetailClass", function () {
  let kode = $(this).attr("data-kode");
  let jurusan = $(this).attr("data-jurusan");
  let titlekode = jurusan + " ( " + kode + " ) ";
  let id = $(this).attr("data-val");
  idjur = id;
  //$(".header-title-prodi").text(tm_jurusan_title);
  $(".header-title-prodi").text(titlekode);
  let url = urlProdi + "/" + id;
  //console.log(url);
  //table.ajax.reload();
  tableProdi.ajax.url(url).load();
  $(".tableElement").hide("slide", { direction: "left" }, 1000, function () {
    $(".tableElementProdi").show("slide", { direction: "left" }, 1000);
    //document.getElementById("frmJurusan").action = actEdit;
  });
});

$("#BtnAddProdi").click(function () {
  event.preventDefault();
  mode = "add";
  $(".tableElementProdi").hide(
    "slide",
    { direction: "left" },
    1000,
    function () {
      $(".formElementProdi").show("slide", { direction: "left" }, 1000);
      document.getElementById("frmProdi").action = "";
    }
  );
  $("#txtProdiKode").val("");
  $("#txtProgramStudiTitle").val("");
  $("#txtIdProgramStudi").val("");

  $("#btnSubmitProdi").html("Simpan Data Program Studi");
  $("#btnCancelProdi").html("Batal Tambah Program Studi");
});

$("#btnSubmitProdi").click(function () {
  event.preventDefault();
  if (mode == "add") {
    let tm_program_studi_kode = $("#txtProdiKode").val();
    let tm_program_studi_title = $("#txtProgramStudiTitle").val();
    let SelectKaprodi = $("#SelectKaprodi").val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
      method: "POST",
      url: prodistore,
      data: {
        kode: tm_program_studi_kode,
        prodi: tm_program_studi_title,
        jurusan_id: idjur,
        kaprodi: SelectKaprodi,
        _token: token,
      },
    }).done(function (msg) {
      //alert( "Data Saved: " + msg );
      //Swal.fire(msg);
      Swal.fire({
        type: "success",
        title: "Berhasil",
        text: "Data Prodi Berhasil Di Simpan",
      });
    });
  } else if (mode == "edit") {
    let tm_program_studi_kode = $("#txtProdiKode").val();
    let tm_program_studi_title = $("#txtProgramStudiTitle").val();
    let SelectKaprodi = $("#SelectKaprodi").val();
    let dataUpdate = $("#txtIdProgramStudi").val();
    $.ajax({
      method: "POST",
      url: dataUpdate,
      data: {
        kode: tm_program_studi_kode,
        prodi: tm_program_studi_title,
        kaprodi: SelectKaprodi,
        kaprodiid: kaprodiid,
        _method: "PUT",
        _token: token,
      },
    }).done(function (msg) {
      //        alert( "Data Saved: " + msg );
      //Swal.fire(msg);
      Swal.fire({
        type: "success",
        title: "Berhasil",
        text: "Data Prodi Berhasil Di Simpan",
      });
    });
  }

  let jurlid = urlProdi + "/" + idjur;
  tableProdi.ajax.url(jurlid).load();
  $(".formElementProdi").hide(
    "slide",
    { direction: "left" },
    1000,
    function () {
      $(".tableElementProdi").show("slide", { direction: "left" }, 1000);
    }
  );
});

$("body").on("click", ".btnEditClassProdi", function () {
  event.preventDefault();
  mode = "edit";
  var currentRow = $(this).closest("tr");
  let _kode = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
  let _title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  //var col3=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
  let id = $(this).attr("data-update");
  $("#txtProdiKode").val(tm_program_studi_kode);
  $("#txtProdiKode").focus();
  $("#txtProgramStudiTitle").val(tm_program_studi_title);
  $("#txtIdProgramStudi").val(id);

  $(".tableElementProdi").hide(
    "slide",
    { direction: "left" },
    1000,
    function () {
      $(".formElementProdi").show("slide", { direction: "left" }, 1000);
    }
  );
  $("#btnSubmitProdi").html("Ubah Data Program Studi");
  $("#btnCancelProdi").html("Batal Ubah Program Studi");
});

$("#BtnBackProdi").click(function () {
  event.preventDefault();
  $(".tableElementProdi").hide(
    "slide",
    { direction: "left" },
    1000,
    function () {
      $(".tableElement").show("slide", { direction: "left" }, 1000);
    }
  );
  //console.log("test");
});

$("#btnCancelProdi").click(function () {
  $(".formElementProdi").hide(
    "slide",
    { direction: "left" },
    1000,
    function () {
      $(".tableElementProdi").show("slide", { direction: "left" }, 1000);
    }
  );

  $("#txtProdiKode").val("");
  $("#txtProgramStudiTitle").val("");
  $("#txttm_program_studi_id").val("");
  $("#SelectKaprodi").val("");
  $("#SelectKaprodi").select2().trigger("change");
});

$("body").on("click", ".btnDeleteClassProdi", function () {
  event.preventDefault();
  var currentRow = $(this).closest("tr");
  let tm_program_studi_title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  var id = $(this).attr("data-val");
  //console.log(id);
  swal
    .fire({
      title: "Hapus Data Program Studi?",
      text: "Anda akan menghapus " + tm_program_studi_title,
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
          url: prodidelete,
          data: { id: id, _token: token },
          dataType: "html",
          success: function (data) {
            swal
              .fire({
                title: "Hapus Data Berhasil!",
                text: "",
                icon: "success",
              })
              .then(function () {
                let jurlid = urlProdi + "/" + idjur;
                tableProdi.ajax.url(jurlid).load();
              });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error deleting!", "Please try again", "error");
          },
        });
      }
    });
});

$(function () {
  setTimeout(function () {
    $(".alert-dismissable").hide("blind", {}, 500);
  }, 3000);
});

$("body").on("click", ".stts", function () {
  //console.log("click");
  var status = $(this).attr("data-val");
  var pk = $(this).attr("data-id");
  if (status == 0) {
    status = 1;
    //$(this).removeClass().addClass("btn btn-rouded btn-info status");
    $(this).removeClass().addClass("btn btn-rouded btn-info stts");
    $(this).attr("data-val", "1");
    //$(this).attr("data-id", pk);
    $(this).text("Aktif");
  } else if (status == 1) {
    status = 0;
    //$(this).removeClass().addClass("btn btn-rouded btn-warning status");
    $(this).removeClass().addClass("btn btn-rouded btn-danger stts");
    $(this).attr("data-val", "0");
    //$(this).attr("data-id", pk);
    $(this).text("Non Aktif");
  }
  var curl = url + pk + "/" + status;
  $.ajax({
    url: "statusMK",
    method: "GET",
    data: { status: status, id: pk },
    dataType: "json",
    success: function (response) {
      if (response) {
      } else {
      }
    },
  });
});

$("body").on("click", ".delete", function () {
  event.preventDefault();
  var currentRow = $(this).closest("tr");
  let jurusan = currentRow.find("td:eq(2)").text(); // get current row 2nd TD
  /*  console.log($(this).closest("tr")); */
  var id = $(this).attr("data-id");
  //console.log(id);
  swal
    .fire({
      title: "Apakah Anda Yakin?",
      text: "Anda akan menghapus " + jurusan,
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
          url: jurusanDelete,
          data: { id: id, _token: token },
          dataType: "html",
          success: function (data) {
            swal
              .fire({
                title: "Hapus Data " + jurusan + "<strong> Berhasil!</strong>",
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
