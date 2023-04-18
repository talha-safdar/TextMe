<?php
require_once('template/head.php'); // access head.php once
require('help/help.php'); // access help.php once ?>
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
                        <h5 class="card-title m-b-0 heading">User Details</h5>
                        <?php alert('checkSent') // method with 'checkSent' run the method if it becomes true ?>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive">
                        <?php
                        if(isset($_SESSION['user_ID'])) // if user is logged in
                        { ?>
                            <!-- div with class name row to contain the contents -->
                            <div class="row border rounder m-3 justify-content-around text-center overflow-hidden  headingNames">
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">User ID</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">Email</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">Full name</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">Username</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">photo</div>
                            </div>
                        <?php }
                        else
                        { ?>
                            <!-- div with class name row to contain the contents -->
                            <div class="row border rounder m-3 justify-content-around text-center overflow-hidden  headingNames">
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">Full name</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">Username</div>
                                <!-- div with col-lg-2 to allocate specific grid -->
                                <div class="col-lg-2">photo</div>
                            </div>
                        <?php } ?>
                        <?php  foreach ($_SESSION['outcomeDetails'] as $row) // loop inside the variable to retrieve each data
                        {
                            if(isset($_SESSION['user_ID'])) // if user is logged in
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
                                    // display the details with the default photo
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
                                $_SESSION['got_user_ID'] =  $row->user_ID; // assign iterated user_ID to global variable 'got_user_ID'
                            }
                            else
                            {
                                if (!empty($row->image)) // if user has photo 
                                {
                                    echo
                                    '<div class="row border rounder m-3 justify-content-around  text-center overflow-hidden fontSize">'.
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
                                        '<div class="col-lg-2 text-nowrap text-truncate">' . $row->full_name. '</div>' .
                                        '<div class="col-lg-2 text-nowrap text-truncate">' . $row->username . '</div>' .
                                    '<div class="row col-lg-2 notClickable">' .
                                            '<div class="col-lg-2 text-nowrap p-2 imgMain">' . '<img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture">' . '</div>' .
                                        '</div>'.
                                    '</div>';
                                }
                                $_SESSION['got_user_ID'] =  $row->user_ID; // assign iterated user_ID to global variable 'got_user_ID'
                            }
                        }
                        ?>
                    </div>
                    <!-- div with justify-content-center to distribute contents equally -->
                    <div class="justify-content-center text-center notClickable cCont notClickable">
                    <?php
                    if(isset($_SESSION['userSent'])) // check if global variable is set to avoid errors
                    {
                        if ($_SESSION['userSent'] == "sent") // if global variable equals to "sent"
                        {
                            $_SESSION['userSent'] = "normal"; // assign "normal" to global variable 'userSent' ?>
                            <a href="../requestsSent.php"><button class="c">Requests Sent List</button></a><?php
                        }
                        else if ($_SESSION['userSent'] == "request") // if global variable equals to "request"
                        {
                            $_SESSION['userSent'] = "normal"; // assign "normal" to global variable 'userSent' ?>
                            <a href="../requests.php"><button class="c">Requests List</button></a><?php
                        }
                        else if ($_SESSION['userSent'] == "friend") // if global variable equals to "friend"
                        {
                            $_SESSION['userSent'] = "normal"; // assign "normal" to global variable 'userSent' ?>
                            <a href="../friends.php"><button class="c">Friend List</button></a><?php
                        }
                    }
                    else
                    { ?>
                        <!-- a with class name c in button to customise the button -->
                        <a href="../loggedInPage.php"><button class="c">Home</button></a> <?php
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../Javascript/Loading.js"></script>
<script type="text/javascript">
    let load = new Loading();
</script>
</body>
<?php require('template/footer.php') // access the footer.php ?>