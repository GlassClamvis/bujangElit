tableMenu = $("#tableMenu").DataTable({
  responsive: true,
  processing: true,
  serverSide: true,
  ajax: getMenu,
  columns: [
    { data: "id" },
    { data: "title" },
    { data: "url" },
    { data: "action" },
  ],
});

tableSubMenu = $("#tableSubMenu").DataTable({
  ordering: false,
  paging: false,
  searching: false,
  ajax: getSubMenu,
});

$(".tableElementSubMenu").slideUp("slow", function () {});

$("#BtnAddMenu").click(function () {
  event.preventDefault();

  $(".tableElement").slideUp("slow", function () {
    $(".formElement").show("slow");
    document.getElementById("frmMenu").action = act;
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

  var title = $(this).attr("data-title");
  var url = $(this).attr("data-url");
  let dataUpdate = $(this).attr("data-update");
  $("#menu").val(title);
  $("#url").val(url);
  $("#metod").val("PUT");
  var act = dataUpdate;

  $(".tableElement").slideUp("slow", function () {
    $(".formElement").show("slow");
    document.getElementById("frmMenu").action = act;
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
  let url = getSubMenu + "/" + globalMenuId;
  tableSubMenu.ajax.url(url).load();

  $(".tableElement").slideUp("slow", function () {
    $(".tableElementSubMenu").show("slow");
  });
});

$("#BtnAddSubMenu").click(function () {
  console.log("clicked AddSubmenu");
  event.preventDefault();
  mode = "add";
  $(".tableElementSubMenu").slideUp("slow", function () {
    $(".formElementSubMenu").show("slow");
  });

  $("#subMenu").val("");
  //$("#globalMenuId").val(globalMenuId);

  $("#btnSubmitSubMenu").html("Simpan Data Sub Menu");
  $("#btnCancelSubMenu").html("Batal Tambah Sub Menu");
});

$("#btnSubmitSubMenu").click(function () {
  event.preventDefault();
  if (mode == "add") {
    let subMenu = $("#subMenu").val();
    //let globalMenuId = $("#subMenu").val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
      method: "POST",
      url: subMenuStore,
      data: {
        subMenu: subMenu,
        globalMenuId: globalMenuId,
        _token: token,
      },
    }).done(function (msg) {
      //alert( "Data Saved: " + msg );
      //Swal.fire(msg);
      Swal.fire({
        type: "success",
        title: "Berhasil",
        text: "Data Sub Menu Berhasil Di Simpan",
      });
      let url = getSubMenu + "/" + globalMenuId;
      tableSubMenu.ajax.url(url).load();
    });
  } else if (mode == "edit") {
    let subMenu = $("#subMenu").val();
    let dataUpdate = $("#subMenuId").val();
    $.ajax({
      method: "POST",
      url: dataUpdate,
      data: {
        subMenu: subMenu,
        _method: "PUT",
        _token: token,
      },
    }).done(function (msg) {
      //        alert( "Data Saved: " + msg );
      //Swal.fire(msg);
      Swal.fire({
        type: "success",
        title: "Berhasil",
        text: "Data Sub Menu Berhasil Di Ubah",
      });

      let url = getSubMenu + "/" + globalMenuId;
      tableSubMenu.ajax.url(url).load();
    });
  }

  $(".formElementSubMenu").slideUp("slow", function () {
    $(".tableElementSubMenu").show("slow");
  });
});

$("body").on("click", ".btnEditClassSubMenu", function () {
  event.preventDefault();
  mode = "edit";
  var currentRow = $(this).closest("tr");
  let title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  let id = $(this).attr("data-update");
  $("#subMenu").val(title);
  $("#subMenuId").val(id);

  $(".tableElementSubMenu").slideUp("slow", function () {
    $(".formElementSubMenu").show("slow");
  });

  $("#btnSubmitSubMenu").html("Ubah Data Sub Menu");
  $("#btnCancelSubMenu").html("Batal Ubah Sub Menu");
});

$("#BtnBackSubMenu").click(function () {
  event.preventDefault();

  $(".tableElementSubMenu").slideUp("slow", function () {
    $(".tableElement").show("slow");
  });
  //console.log("test");
});

$("#btnCancelSubMenu").click(function () {
  $(".formElementSubMenu").slideUp("slow", function () {
    $(".tableElementSubMenu").show("slow");
  });
  $("#subMenu").val("");
  $("#subMenuId").val("");
});

$("body").on("click", ".btnDeleteClassSubMenu", function () {
  event.preventDefault();
  var currentRow = $(this).closest("tr");
  let title = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
  var id = $(this).attr("data-val");
  //console.log(id);
  swal
    .fire({
      title: "Hapus Data SubMenu?",
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
          url: subMenuDelete,
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
                let url = getSubMenu + "/" + globalMenuId;
                tableSubMenu.ajax.url(url).load();
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
          url: menuDelete,
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
                tableMenu.ajax.reload();
              });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error deleting!", "Please try again", "error");
          },
        });
      }
    });
});
