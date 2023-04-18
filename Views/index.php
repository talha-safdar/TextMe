<?php
require('template/header.php'); // access head.php ?>
<body>
<div id="loading" class="loading">
    <div class="innerLoading"><img src="../images/website/images/Ripple-1s-200px%20(1).gif" height="200" width="200" alt="load" /></div>
</div>
<?php require('template/loginPage.php'); // access loginPage.php ?>
<?php require('template/searchAll.php'); ?>
    <!-- container for the sub-contents -->
    <div id="mainTable" class="container containerTable col-xs-2 containerUsers">
        <!-- div with class name welcomeContainer to contain the contents -->
        <div class="welcomeContainer d-flex justify-content-between">
            <!-- h3 with col-lg-3 to allocate a specific grid and display a text -->
            <h3 class="welcome">Welcome Guest</h3>
        </div>
        <!-- div with class name row to contain the contents -->
        <div class="row tableStyle ">
            <!-- div with class name with column number limit -->
            <div class="col-md-12 tableCol">
                <!-- div with card name to create a card  -->
                <div class="card">
                    <!-- div with card-body to add contents inside -->
                    <div class="card-body text-center">
                        <!-- h5 with card-tile to display a text -->
                        <h5 class="card-title m-b-20 heading">Users registered</h5>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive">
                        <!-- div with class name row to contain the contents -->
                        <div class="row border rounder m-3 justify-content-around text-center overflow-hidden headingNames">
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-3">Full Name</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-3">Username</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-3">Photo</div>
                        </div>
                        <?php if (!empty($view)) // if variable $view is not empty
                        {
                            foreach ($view->userDataSet as $userData) // loop inside the variable to retrieve each data
                            {
                                if (!empty($userData->getUserPhoto())) // if user has photo
                                {
                                    // display details with the photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getFullName() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUsername() . '</a></div>' .
                                    '<div class="row col-lg-3 notClickable">' .
                                            '<div class=" p-2"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '"><img class="profPic" src="../images/users/' . $userData->getUserPhoto() . '" height="100px" width="100px" alt="profile picture">' . '</a></div>' .
                                        '</div>' .
                                    '</div>';
                                }
                                else
                                {
                                    // display the details with the default photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getFullName() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUsername() . '</a></div>' .
                                        '<div class="row col-lg-3">' .
                                    '<div class="col-lg-3 text-nowrap p-2 imgMain notClickable">' . '<img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture">' . '</div>' .
                                        '</div>' .
                                    '</div>';
                                }
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../Javascript/LoginSystem.js"></script>
<script src="../Javascript/ValidationLogin.js"></script>
<script src="../Javascript/Loading.js"></script>
<script type="text/javascript">
    let loginSystem = new LoginSystem();
    let load = new Loading();
    let validation = new ValidationLogin();
</script>
</body>
<?php require('template/pagination.php') // access the pagination.php ?>
<?php require('template/footer.php') // access the footer.php ?>