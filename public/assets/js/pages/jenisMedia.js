tableJenisMedia = $("#tableJenisMedia").DataTable({
  responsive: true,
  processing: true,
  serverSide: true,
  ajax: getjenisMedia,
  columns: [{ data: "id" }, { data: "media" }, { data: "action" }],
});

tableProperties = $("#tableProperties").DataTable({
  ordering: false,
  paging: false,
  searching: false,
  ajax: getjenisMediaProperties,
});

$(".tableElementProperti").slideUp("slow", function () {});

$("#BtnAddJenisMedia").click(function () {
  event.preventDefault();

  $(".tableElement").slideUp("slow", function () {
    $(".formElement").show("slow");
    document.getElementById("frmJenisMedia").action = act;
  });

  $("#btnSubmit").html("Simpan Data Menu");
  $("#btnCancel").html("Batal Tambah Menu");
  //console.log(urlProdi);
});

$("#btnCancel").click(function () {
  $(".formElement").slideUp("slow", function () {
    $(".tableElement").show("slow");
  });
  $("#menu").val("");
  $("#url").val("");
});

$("body").on("click", ".btnEditClass", function () {
  event.preventDefault();

  var label = $(this).attr("data-label");
  let dataUpdate = $(this).attr("data-update");
  $("#jenismedia").val(label);
  $("#metod").val("PUT");
  var act = dataUpdate;

  $(".tableElement").slideUp("slow", function () {
    $(".formElement").show("slow");
    document.getElementById("frmJenisMedia").action = act;
  });

  $("#btnSubmit").html("Ubah Data Menu");
  $("#btnCancel").html("Batal Ubah Menu");
});

$("body").on("click", ".btnDetailClass", function () {
  let menu = $(this).attr("data-menu");
  globalMenuId = $(this).attr("data-val");
  //console.log(id);
  //globalMenuId = id;
  $(".header-title-SubMenu").text(menu);
  let url = getjenisMediaProperties + "/" + globalMenuId;
  tableProperties.ajax.url(url).load();

  $(".tableElement").slideUp("slow", function () {
    $(".tableElementProperti").show("slow");
  });
});

$("#BtnAddProperti").click(function () {
  event.preventDefault();
  mode = "add";
  $(".tableElementProperti").slideUp("slow", function () {
    $(".formElementProperti").show("slow");
  });

  $("#properti").val("");
  //$("#globalMenuId").val(globalMenuId);

  $("#btnSubmitProperties").html("Simpan Data Properti Media");
  $("#btnCancelProperties").html("Batal Tambah Properti Media");
});

$("#btnSubmitProperties").click(function () {
  event.preventDefault();
  let properti = $("#properti").val();
  if (properti != "") {
    if (mode == "add") {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
      $.ajax({
        method: "POST",
        url: jenisMediaPropertiesStore,
        data: {
          properti: properti,
          globalMenuId: globalMenuId,
          _token: token,
        },
      }).done(function (msg) {
        //alert( "Data Saved: " + msg );
        //Swal.fire(msg);
        Swal.fire({
          type: "success",
          title: "Berhasil",
          text: "Data Property Media Berhasil Di Simpan",
        });
        let url = getjenisMediaProperties + "/" + globalMenuId;
        tableProperties.ajax.url(url).load();
      });
    } else if (mode == "edit") {
      let dataUpdate = $("#propertiId").val();
      $.ajax({
        method: "POST",
        url: dataUpdate,
        data: {
          properti: properti,
          _method: "PUT",
          _token: token,
        },
      }).done(function (msg) {
        //        alert( "Data Saved: " + msg );
        //Swal.fire(msg);
        Swal.fire({
          type: "success",
          title: "Berhasil",
          text: "Data Properti Berhasil Di Ubah",
        });

        let url = getjenisMediaProperties + "/" + globalMenuId;
        tableProperties.ajax.url(url).load();
      });
    }
  }

  $(".formElementProperti").slideUp("slow", function () {
    $(".tableElementProperti").show("slow");
  });
});

$("body").on("click", ".btnEditClassProperties", function () {
  event.preventDefault();
  mode = "edit";
  var currentRow = $(this).closest("tr");
  let title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  let id = $(this).attr("data-update");
  $("#properti").val(title);
  $("#propertiId").val(id);

  $(".tableElementProperti").slideUp("slow", function () {
    $(".formElementProperti").show("slow");
  });

  $("#btnSubmitProperties").html("Ubah Data Properti Media");
  $("#btnCancelProperties").html("Batal Ubah Properti Media");
});

$("#BtnBackProperti").click(function () {
  event.preventDefault();

  $(".tableElementProperti").slideUp("slow", function () {
    $(".tableElement").show("slow");
  });
  //console.log("test");
});

$("#btnCancelProperties").click(function () {
  $(".formElementProperti").slideUp("slow", function () {
    $(".tableElementProperti").show("slow");
  });
  $("#subMenu").val("");
  $("#subMenuId").val("");
});

$("body").on("click", ".btnDeleteClassProperties", function () {
  event.preventDefault();
  var currentRow = $(this).closest("tr");
  let title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  var id = $(this).attr("data-val");
  //console.log(id);
  swal
    .fire({
      title: "Hapus Data Properti Media?",
      text: "Anda akan menghapus " + title,
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
          url: jenisMediaPropertiesDelete,
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
                let url = getjenisMediaProperties + "/" + globalMenuId;
                tableProperties.ajax.url(url).load();
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
    $(".alert-dismissable").slideUp("slow");
  }, 3000);
});

$("body").on("click", ".stts", function () {
  //console.log("click");
  var status = $(this).attr("data-val");
  var pk = $(this).attr("data-id");
  if (status == 0) {
    status = 1;
    //$(this).removeClass().addClass("btn btn-rouded btn-info status");
   
  } else if (status == 1) {
    status = 0;
    //$(this).removeClass().addClass("btn btn-rouded btn-warning status");
    $(this).removeClass().addClass("btn btn-rouded btn-danger stts");
    $(this).attr("data-val", "0");
    //$(this).attr("data-id", pk);
    $(this).text("Non Aktif");
  }
  $.ajax({
    url: statusJenisMediaProperties,
    method: "GET",
    data: { status: status, id: pk },
    dataType: "json",
    success: function (response) {
      if(response.status==200){
        swal
              .fire({
                title: "Perubahan Aktif / Non Aktif Berhasil",
                text: "",
                icon: "success",
              })
              .then(function () {
                let url = getjenisMediaProperties + "/" + globalMenuId;
                tableProperties.ajax.url(url).load();
              });
      }else{

      }
    },
  });
});

$("body").on("click", ".isCek", function () {
  console.log("click IsCek");
  var status = $(this).attr("data-val");
  var pk = $(this).attr("data-id");
  if (status == 0) {
    status = 1;
  } else if (status == 1) {
    status = 0;
  }

  $.ajax({
    url: isCekJenisMedia,
    method: "GET",
    data: { status: status, id: pk },
    dataType: "json",
    success: function (response) {
      if(response.status==200){
        swal
              .fire({
                title: "Perubahan Cek / Not Cek Berhasil",
                text: "",
                icon: "success",
              })
              .then(function () {
                let url = getjenisMediaProperties + "/" + globalMenuId;
                tableProperties.ajax.url(url).load();
              });
      }else{

      }
    },
  });
 
});


$("body").on("click", ".delete", function () {
  event.preventDefault();
  var currentRow = $(this).closest("tr");
  let menu = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  /*  console.log($(this).closest("tr")); */
  var id = $(this).attr("data-id");
  //console.log(id);
  swal
    .fire({
      title: "Apakah Anda Yakin?",
      text: "Anda akan menghapus " + menu,
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
          url: jenisMediaDelete,
          data: { id: id, _token: token },
          dataType: "html",
          success: function (data) {
            swal
              .fire({
                title: "Hapus Data " + menu + "<strong> Berhasil!</strong>",
                text: "",
                icon: "success",
              })
              .then(function () {
                tableJenisMedia.ajax.reload();
              });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error deleting!", "Please try again", "error");
          },
        });
      }
    });
});

$("body").on("click",".classDown",function(){
  event.preventDefault();
  let dtVal= $(this).attr("data-val");
  let splitDtVal = dtVal.split("-");
  let posisi = splitDtVal[1];
  let posisi2 = parseInt(posisi)+1;
  move(posisi,posisi2);
});

$("body").on("click",".classUp",function(){
  event.preventDefault();
  let dtVal= $(this).attr("data-val");
  let splitDtVal = dtVal.split("-");
  let posisi = splitDtVal[1];
  let posisi2 = parseInt(posisi)-1;
  move(posisi, posisi2);
});

function move(posisi, posisi2){
  let dtPosisi2 = $("#tm_pertanyaan_label-"+posisi2).text();
  let valPosisi2 = $("#tm_pertanyaan_label-"+posisi2).attr("data-val");
  let valPosisi = $("#tm_pertanyaan_label-"+posisi).attr("data-val");
  $("#tm_pertanyaan_label-"+posisi2).text($("#tm_pertanyaan_label-"+posisi).text());
  $("#tm_pertanyaan_label-"+posisi).text(dtPosisi2);
  $("#tm_pertanyaan_label-"+posisi2).attr("data-val",valPosisi);
  $("#tm_pertanyaan_label-"+posisi).attr("data-val",valPosisi2);
  console.log(posisi2+"^"+valPosisi);
  console.log(posisi+"^"+valPosisi2);
  let updatePertanyaan    = "{{route('PertanyaanUrutan')}}";
  $.get( updatePertanyaan, { id: valPosisi, urutan: posisi2, ids:valPosisi2, urutans:posisi } );
}
