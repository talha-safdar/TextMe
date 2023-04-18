/**
 * the class UploadImage which extends GenerateToken
 * serves to preview, customise and upload the image
 */
class UploadImage extends GenerateToken
{
    constructor()
    {
        super();
        this.preview = document.getElementById('previewImage'); // <img>
        this.realFile = document.getElementById('fileButton'); // <input>
        this.uploaded = document.getElementById('uploadImage'); // button to upload
        this.greyscale = document.getElementById('greyscale'); // filter
        this.zoomInn = document.getElementById('in');
        this.zoomOutt = document.getElementById('out');
        this.reader = new FileReader();
        this.formData = new FormData(); // for preview
        this.canvas = {};
        this.file = {};
        this.ctx = {};

        this.img = document.getElementById('previewImage');
        this.inn = document.getElementById('in');
        this.outt = document.getElementById('out');

        // to disable buttons and checkbox
        this.uploaded.disabled = true;
        this.greyscale.disabled = true;
        document.getElementById('in').disabled = true;
        document.getElementById('in').style.opacity = "0.5";
        document.getElementById('out').disabled = true;
        document.getElementById('out').style.opacity = "0.5";
        document.getElementById('filterName').style.opacity = "0.5";

        document.getElementById('fileButton').addEventListener("change", this.previewFile);
        document.getElementById('greyscale').addEventListener("click", this.applyFilter);
        document.getElementById('in').addEventListener("click", this.zoomIn);
        document.getElementById('out').addEventListener("click", this.zoomOut);
        document.getElementById('uploadImage').addEventListener("click", this.uploadFile);
    }


    /**
     * to upload the image to the server
     * @returns {Promise<void>}
     */
    async uploadFile()
    {
        self.canvas = document.getElementById('canvasImage');
        self.ctx = self.canvas.getContext('2d');
        if(self.greyscale.checked == true)
        {
            self.ctx.filter = 'grayscale(1)';
        }
        self.ctx.clearRect(0, 0, self.canvas.width, self.canvas.height);
        self.ctx.drawImage(document.getElementById('previewImage'), self.canvas.width/2 - document.getElementById('previewImage').width/2, self.canvas.height/2 - document.getElementById('previewImage').height/2, document.getElementById('previewImage').width, document.getElementById('previewImage').height); // destination rectangle
        const canvas = document.getElementById('canvasImage');
        const file = UploadImage.dataURLtoBlob(canvas.toDataURL());
        const fd = new FormData;
        fd.append('file', file);
        await fetch('../Ajax/uploadingImage.php?token=' + token.getToken(),
            {
                method: "POST",
                body: fd
            });
        // disable the input, checkbox, and all the buttons
        document.getElementById('fileButton').disabled = true;
        document.getElementById('uploadImage').outerHTML = '<button class="btn btn-success photoUpload disabled">UPLOADED</button>';
        document.getElementById('in').disabled = true;
        document.getElementById('in').style.opacity = "0.5";
        document.getElementById('out').disabled = true;
        document.getElementById('out').style.opacity = "0.5";
        document.getElementById('greyscale').disabled = true;
        document.getElementById('filterName').style.opacity = "0.5";
    }

    /**
     * to display the uploaded image
     */
    previewFile()
    {
        self.file = document.getElementById('fileButton').files[0];
        console.log(document.getElementById('fileButton'));
        let formData = new FormData(); // for preview
        let reader = new FileReader();
        formData.append('file', document.getElementById('fileButton'));
        reader.addEventListener("load", function () {
            document.getElementById('previewImage').src = reader.result;
        }, false);

        if (self.file) {
            reader.readAsDataURL(self.file);
        }
        document.getElementById('uploadImage').disabled = false;
        document.getElementById('greyscale').disabled = false;
        document.getElementById('in').disabled = false;
        document.getElementById('in').style.opacity = "1.0";
        document.getElementById('out').disabled = false;
        document.getElementById('out').style.opacity = "1.0";
        document.getElementById('filterName').style.opacity = "1.0";
    }

    /**
     * to zoom in the image
     */
    zoomIn()
    {
        if (UploadImage.photoUploaded == false)
        {
            document.getElementById('previewImage').style.width = (document.getElementById('previewImage').clientWidth + 5) + "px";
        }
    }

    /**
     * to zoom out the image
     */
    zoomOut()
    {
        if (UploadImage.photoUploaded == false)
        {
            document.getElementById('previewImage').style.width = (document.getElementById('previewImage').clientWidth - 5) + "px";
        }

    }

    /**
     * to apply the filter to the image
     */
    applyFilter()
    {
        if (self.greyscale.checked == true)
        {
            document.getElementById('previewImage').style.filter = "grayscale(1)";
        }
        else
        {
            document.getElementById('previewImage').style.filter = "none";
        }
    }
}

/**
 * to convert the format to blob
 * @param dataURL
 * @returns {Blob}
 */
UploadImage.dataURLtoBlob = function (dataURL)
{
    // from stackOverflow
    let array, binary, i, len;
    binary = atob(dataURL.split(',')[1]);
    array = [];
    i = 0;
    len = binary.length;
    while (i < len) {
        array.push(binary.charCodeAt(i));
        i++;
    }
    return new Blob([new Uint8Array(array)], { type: 'image/png' });
}

UploadImage.photoUploaded = false; // to confirm if photo has been uploaded