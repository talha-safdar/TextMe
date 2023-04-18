<?php
require_once('template/header.php'); // access head.php once ?>
<body>
<div id="loading" class="loading">
    <div class="innerLoading"><img src="../images/website/images/Ripple-1s-200px%20(1).gif" height="200" width="200" alt="load" /></div>
</div>
    <!-- container for the sub-contents -->
    <div class="container containerTable">
        <!-- div with class name row to contain the contents -->
        <div class="row tableStyle userDetailsContainer">
            <!-- div with class name with column number limit -->
            <div class="col-sm-12 tableCol">
                <!-- div with card name to create a card  -->
                <div class="card">
                    <!-- div with card-body to add contents inside -->
                    <div class="card-body text-center">
                        <!-- h5 with card-title to display a text message -->
                        <h5 class="card-title m-b-0 heading">Profile</h5>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive">
                        <!-- div with class name row to contain the contents -->
                        <div class="row border rounder m-3 justify-content-around text-center overflow-hidden  headingNames">
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">User ID</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Email Address</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Full name</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Username</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">photo</div>
                        </div>
                        <?php  foreach ($_SESSION['profileDetails'] as $row) // loop inside the variable to retrieve each data
                        {
                            if (!empty($row->image)) // if user has photo 
                            {
                                // display details with the photo
                                echo
                                // each line calls a method from UserDataDet class
                                '<div class="row border rounder m-3 justify-content-around  text-center overflow-hidden fontSize">'.
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->user_ID . '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->email_address . '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->full_name. '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->username . '</div>' .
                                '<div class="row col-lg-2 notClickable">' .
                                        '<div class="col-lg-2 text-nowrap p-2 imgMain">' . '<img class="profPic" src="../images/users/' .  $row->image . '" height="100px" width="100px" alt="profile picture">'.'</div>' .
                                    '</div>'.
                                '</div>';
                            }
                            else
                            {
                                // display details with the photo
                                echo
                                // each line calls a method from UserDataDet class
                                '<div class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">'.
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->user_ID . '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->email_address . '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->full_name. '</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">' . $row->username . '</div>' .
                                '<div class="row col-lg-2 notClickable">' .
                                        '<div class="col-lg-2 text-nowrap p-2 imgMain">' . '<img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture">' . '</div>' .
                                    '</div>'.
                                '</div>';
                            }
                        } ?>
                    </div>
                    <!-- div with justify-content-center to distribute contents equally -->
                    <div class="justify-content-center text-center notClickable cCont">
                        <!-- a with c to customise the button -->
                        <a href="../loggedInPage.php "><button class="c">Home</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../Javascript/Loading.js"></script>
<script src="../Javascript/Audio.js"></script>
<script type="text/javascript">
    let load = new Loading();
</script>
</body>
<?php require('template/footer.php') // access the footer.php ?>