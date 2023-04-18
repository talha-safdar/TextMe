<?php
require_once('template/header.php'); // access head.php once
include_once('./help/help.php'); // access help.php once ?>
<body>
<!-- div with class name loginContainer (inherited from login) to contain contents -->
    <div class="loginContainer notClickable">
        <!-- div with class name to contain the logo -->
        <div class="brand">
            <!-- div with class name logoImgContainer to accommodate the logo image -->
            <div class="logoImgContainer">
                <!-- img with class name logoImg to customise the photo -->
                <img class="logoImg" src="../images/website/images/logo.png" alt="logo">
            </div>
        </div>
        <div id="errorMessageRegister"></div>
        <!-- form with class name form to contain the contents to obtain inputs from the user -->
        <div class="form notClickable">
        <br>
            <!-- label with class name log to display the instructive text -->
            <label id="emailL" class="inputTitle" for="email_address">Email Address/Username</label><br>
            <!-- input to allow the user to type in -->
            <input id="email" type="text"name="email_address" value=""><br><br>
            <!-- label with class name log to display the instructive text -->
            <label id="nameL" class="inputTitle" for="full_name">Full Name:</label><br>
            <!-- input to allow the user to type in -->
            <input id="name" type="text" name="full_name" value=""><br><br>
            <!-- label with class name log to display the instructive text -->
            <label id="usernameL" class="inputTitle" for="username">Username:</label><br>
            <!-- input to allow the user to type in -->
            <input id="username" type="text" name="username" value="" placeholder=" white spaces not allowed"><br><br>
            <!-- label with class name log to display the instructive text -->
            <label id="passwordL" class="inputTitle" for="password">Password:</label><br>
            <!-- input to allow the user to type in -->
            <input id="password" type="password" name="password" value="" placeholder="     at least 6 characters"><br><br>
            <!-- label with class name log to display the instructive text -->
            <label id="passwordRepeatL" class="inputTitle" for="passwordRepeat">Repeat Password:</label><br>
            <!-- input to allow the user to type in -->
            <input id="passwordRepeat" type="password" name="passwordRepeat" value=""><br><br>
            <!-- label with class name log to display the instructive text -->
            <label class="inputTitle" for="humanVerification">Type the code below:</label><br>
            <!-- label with class name log to display the instructive text -->
            <label class="inputTitle" for="humanVerification"></label><?php echo $_SESSION['verificationCode'] ?><br>
            <!-- input to allow the user to type in -->
            <input id="humanVerification" type="text" name="humanVerification" placeholder="     human verification"><br><br>
            <input id="bot" class="antispam" type="text" name="bot">
            <!-- input to allow the user to type in -->
            <input id="registeredButton" type="submit" value="Submit" name="register" class="btn btn-secondary"><br><br>
            <!-- a with register to customise the text and redirect to login page -->
            <a class="register" href="../index.php">Go Back</a>
        </div>
    </div>
</body>
<script src="../Javascript/ValidationRegister.js"></script>
<script type="text/javascript">
    let validationRegister = new ValidationRegister();
</script>
<?php require('template/footer.php') // access the footer.php ?>