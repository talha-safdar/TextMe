<?php
require('template/header.php'); // access header.php ?>
<br>
<body>
<?php require('template/searchAll.php'); ?>
<div id="loading" class="loading">
    <div class="innerLoading"><img src="../images/website/images/Ripple-1s-200px%20(1).gif" height="200" width="200" alt="load" /></div>
</div>
    <!-- container for the sub-contents -->
    <div class="container containerTable containerUsers">
        <!-- div with class name welcomeContainer to contain welcome message -->
        <div class="welcomeContainer d-flex justify-content-between">
            <!-- h3 with class name welcome to include a text -->
            <h3 class="col-xs-12 welcome d-flex justify-content-end flex-column">Welcome <?php echo explode(" ", $_SESSION['full_name'])[0] // divide variable 'full_name' using " " delimiter?>
            <?php if(isset($_SESSION['user_ID']) && (!$_SESSION['image'])) // if user is logged in and has no photo
            { ?>  </h3>
                <!-- if above condition is true show the following message -->
                <a href="../uploadImage.php"><button class="uploading notClickable spacerWelcome">Upload Photo</button></a><?php
            } ?>

        </div>
        <!-- div with class name row to contain the contents -->
        <div id="hideSearch" class="row tableStyle">
            <!-- div with class name with column number limit -->
            <div class="col-sm-12 tableCol">
                <!-- div with card name to create a card  -->
                <div class="card">
                    <!-- div with card-body to add contents inside -->
                    <div class="card-body text-center headingNames">
                        <!-- h5 with card-title to display a text message -->
                        <h5 class="card-title m-b-0 heading">Users registered</h5>
                            <!-- if above condition is true show the following message -->
                            <p id="notPlace" class=""></p>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive ">
                        <!-- div with class name justify-content-center to contain the contents -->
                        <div id="buttonsWrap" class="justify-content-center text-center notClickable">
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <a href="../Models/Core.php?profile=<?php $_SESSION['user_ID'] ?>"><button class="btn-lg c">Profile</button></a>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <a id="requestsButton"><button class="btn-lg c">Requests</button></a>
                            <a id="sentButton"><button class="btn-lg c">Sent</button></a>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <a id="friendsButton"><button class="btn-lg c">Friends</button></a>
                        </div>
                        <!-- div with class name row to contain the contents -->
                        <div class="row border rounder m-3 justify-content-around text-center overflow-hidden headingNames">
                            <div class="col-lg-3">Email</div>
                            <div class="col-lg-3">Full Name</div>
                            <div class="col-lg-3">Username</div>
                            <div class="col-lg-3">Photo</div>
                        </div>
                        <?php if (!empty($view)) // if variable $view is set
                        {
                            foreach ($view->userDataSet as $userData) // loop inside the variable to retrieve each data
                            {
                                if($userData->getUserID() == $_SESSION['user_ID']) // if global variable 'user_ID' equals to iterated variable
                                {
                                    continue; // ignore the following steps
                                }
                                if(!empty($userData->getUserPhoto())) // if user has photo
                                {
                                    // display details with the photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around justify-content-lg-end text-center overflow-hidden fontSize">'.
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUserEmail() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getFullName() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUsername() . '</a></div>' .
                                    '<div class="row col-lg-3 notClickable">' .
                                            '<div class=" p-2"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '"><img class="profPic" src="../images/users/' .  $userData->getUserPhoto() . '" height="100px" width="100px" alt="profile picture">'.'</a></div>' .
                                        '</div>'.
                                    '</div>';
                                }
                                else
                                {
                                    // display details with the photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">'.
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUserEmail() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getFullName() . '</a></div>' .
                                        '<div class="col-lg-3 text-nowrap text-truncate"><a class="clickUser" href="../Models/Core.php?user_ID_details=' . $userData->getUserID() . '">' . $userData->getUsername() . '</a></div>' .
                                    '<div class="row col-lg-3 notClickable">' .
                                            '<div class="col-lg-3 text-nowrap p-2 imgMain">' . '<img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture">' . '</div>' .
                                        '</div>'.
                                    '</div>';
                                }
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../Javascript/Loading.js"></script>
<script src="../Javascript/UserButtons.js"></script>
<script src="../Javascript/Audio.js"></script>
<script src="../Javascript/ObtainLocation.js"></script>
<script type="text/javascript">
    let load = new Loading();
    let userButtons = new UserButtons();
</script>
</body>
<?php require('template/pagination.php') // access the pagination.php ?>
<?php require('template/footer.php') // access the footer.php ?>