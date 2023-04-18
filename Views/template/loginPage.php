
<div  id="scroll-index" class="outer-popup-login">
    <div class="login-contents">
        <div class="loginContainer notClickable">
            <!-- div with class name to contain the logo -->
            <div class="brand">
                <!-- div with class name logoImgContainer to accommodate the logo image -->
                <div class="logoImgContainer">
                    <!-- img with class name logoImg to customise the photo -->
                    <img class="logoImg" src="../../images/website/images/logo.png" alt="logo">
                </div>
            </div>
            <div id="errorMessageLogin"></div>
            <!-- form with class name form to contain the contents to obtain inputs from the user -->
            <div class="form notClickable">
                <br>
                <!-- label with class name log to display the instructive text -->
                <label class="inputTitle" for="emailAddress">Email Address:</label><br>
                <!-- input to allow the user to interact -->
                <input id="email" type="text" name="emailAddress" value="<?php if(isset($_SESSION['registeredEmail'])) { echo $_SESSION['registeredEmail']; } ?>"><br><br>
                <!-- label with class name log to display the instructive text -->
                <label class="inputTitle" for="password">Password:</label><br>
                <!-- input to allow the user to interact -->
                <input id="password" type="password" name="password" value=""><br><br>
                <!-- input to allow the user to interact -->
                <input id="loggedInButton" type="submit" value="Submit" name="login" class="btn btn-secondary"><br><br>
                <!-- a with class name register to customise the text and redirect to registration page -->
                <a class="register" href="../register.php">Sign Up</a><br><br>
                <!-- a with register to customise the text and redirect to home page -->
                <div class="closeLoginFrame">
                    <div id="clearSearch" class="closeBoxSearch loginCloseBox"><div id="closeLogin" class="closeSearchAll"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>