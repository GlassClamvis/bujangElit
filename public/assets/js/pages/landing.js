function initBukuDetail() {
    heartClick(false);
}

function initJurnalDetail() {
    heartClick(false);
    evaluated();
    evaluationSubmit();
}

function initBookmark() {
    heartClick(true);
}

function heartClick(v) {
    $("body").on("click", "#icon-download", function (e) {
        e.preventDefault();
        let iconClick = $(this);
        let mediaId = $(this).data("id");
        let val = $(this).data("val");
        if (val) {
            msg = "Bookmark Berhasil Dihapus!";
            color = "#777777";
            newVal = 0;
        } else {
            msg = "Bookmark Berhasil Dibuat!";
            color = "#FF1493";
            newVal = 1;
        }
        var iconElement = $("#icon-download i");

        $.ajax({
            type: "POST",
            url: bookmark,
            data: { mediaId: mediaId, val: val, _token: csrf },
            dataType: "html",
            success: function (data) {
                swal.fire({
                    title: msg,
                    text: "",
                    icon: "success",
                }).then(function () {
                    iconElement.css("color", color);
                    iconClick.data("val", newVal);
                    if (v) {
                        location.reload();
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Boomark Gagal Dibuat!", "Please try again", "error");
            },
        });
    });
}

function evaluated(){
    $("body").on("click", ".btnDownload", function (e) {
        e.preventDefault();
        let fileid = $(this).attr("data-fileid");
        console.log("clicked#"+fileid);
        $('#fileid').val(fileid);
        $("#mdlEvaluated").modal("show");
    });
}

function evaluationSubmit(){
    $("body").on("click", "#submitEvaluation", function (e) {
        var formData = $('#formEvaluation').serialize();
        // Perform AJAX request
        $.ajax({
            type: 'POST', // or 'GET' depending on your server-side implementation
            url: evaluationDownload, // replace with your server endpoint
            data: formData,
            success: function(response) {
                $("#mdlEvaluated").modal("hide");
                //console.log('Server response:', response);
                // Handle the response from the server
            },
            error: function(error) {
                console.error('Error:', error);
                // Handle errors
            }
        });
    });
}
