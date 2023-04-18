<?php
require_once("template/header.php"); // access header.php once ?>
<body>
    <!-- div with class name container to contain contents inside -->
    <div class="container containerTable notClickable">
        <!-- div with class name loginContainer to contain contents -->
        <div class="loginContainer notClickable">
            <!-- div with class name to contain the logo -->
            <div class="brand">
                <!-- div with class name logoImgContainer to accommodate the logo image -->
                <div class="logoImgContainer">
                    <!-- img with class name logoImg to customise the photo -->
                    <img class="logoImg" src="../images/website/images/logo.png" alt="logo">
                </div>
            </div>
                <input id="fileButton" type="file"  class="inputImage">
                <br>
            <div class="frameWrapper">
                <div class="imgFramePreviewPhoto">
                    <img id="previewImage" class="previewPhoto" width="180px" height="180px" src=""  alt=" ">
                </div>
            </div>
            <canvas id="canvasImage" width="180px" height="180px" style="display: none"></canvas>
            <div class="checkGrey">
                <label id="filterName" class="greyscaleFont" for="greyscale">greyscale</label>
                <input type="checkbox" id="greyscale" value="greyscale">
            </div>
            <div class="buttWrap">
                <button class="uploadImage mrgZoomIn" id="in">Zoom in</button>
                <button class="uploadImage" id="out">Zoom out</button>
            </div>
                <div class="uploadImageWrap">
                    <!-- buton with class name uploadImage to allow use to submit photo -->
                    <button id="uploadImage" class="btn btn-success photoUpload" type="submit" name="uploadImage">UPLOAD</button>
                </div>
<!--            </form>-->
            <br>
            <!-- div with class name row to contain the content -->
            <div class="justify-content-center text-center notClickable cCont">
                <!-- a with class name home in button to customise the button -->
                <a href="../loggedInPage.php "><button class="c">Home</button></a>
            </div>
        </div>
    </div>
<script src="../Javascript/UploadImage.js"></script>
<script type="text/javascript">
    let uploadImage = new UploadImage();
</script>
</body>
<?php require_once("template/footer.php"); // access the footer.php ?>