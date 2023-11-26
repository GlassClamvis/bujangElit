import Quill from "quill";
import ImageDrop from "quill-image-drop-module";

// Register the imageDrop module
Quill.register("modules/imageDrop", ImageDrop);
quill = new Quill("#berita", {
    theme: "snow",
    modules: {
        toolbar: [
            [{ font: [] }, { size: [] }],
            ["bold", "italic", "underline", "strike"],
            [{ color: [] }, { background: [] }],
            [{ script: "super" }, { script: "sub" }],
            [{ header: [!1, 1, 2, 3, 4, 5, 6] }, "blockquote", "code-block"],
            [
                { list: "ordered" },
                { list: "bullet" },
                { indent: "-1" },
                { indent: "+1" },
            ],
            ["direction", { align: [] }],
            ["link", "image", "video"],
            ["clean"],
            [{ image: "true" }],
        ],
        imageDrop: {
            handler: function (imageData, callback) {
                var formData = new FormData();
                formData.append("image", imageData);

                fetch("/upload-image", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        callback(data.url);
                    })
                    .catch((error) => {
                        console.error("Image upload error:", error);
                        callback(""); // Pass an empty string to indicate failure
                    });
            },
        },
        imageResize: {
            displaySize: true,
        },
    },
});
