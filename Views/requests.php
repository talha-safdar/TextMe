<?php
require_once('template/header.php'); // access head.php once
require_once('./help/help.php'); // access help.php once ?>
<body>
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
                    <?php
                    if(!empty($view->userDataSet)) // check if userDataSet is set
                    { ?>
                        <!-- h5 with card-title to display a text message -->
                        <h5 class="card-title m-b-0 heading">Your Requests list</h5>
                    <?php alert('checkReceived')  // method with 'checkReceived' run the method if it becomes true ?>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive">
                        <!-- div with class name row to contain the contents -->
                        <div class="row border rounder m-3 justify-content-around text-center overflow-hidden  headingNames">
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Email Address</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Full Name</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Username</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">photo</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Confirm</div>
                        </div>
                        <?php
                        foreach ($view->userDataSet as $row) // loop inside the variable to retrieve each data
                        {
                            if (!empty($row->getUserPhoto())) // if user has photo 
                            {
                                $_SESSION['got_it'] =  $row->getUserID();
                                $_SESSION['not_got_it'] = $row->getUserID();
                                // display details with the photo
                                echo

                                // each line calls a method from UserDataDet class
                                '<div onclick="eliminate(this)" class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">'.
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . $row->getUserEmail() . '</a>'.'</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . $row->getFullName() . '</a>'.'</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . $row->getUsername() . '</a>'.'</div>' .
                                '<div class="row col-lg-2 notClickable">' .
                                        '<div class="col-lg-2 text-nowrap p-2 imgMain">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . '<img class="profPic" src="../images/users/' .  $row->getUserPhoto() . '" height="100px" width="100px" alt="profile picture">'.'</a>'.'</div>' .
                                    '</div>' ?>
                                     <div class="col-lg-2 notClickable fCont">
                                        <a onclick="confirm(this, <?php echo "1" . $row->getUserID() ?>)" ><button class="btn btn-success f">Yes</button></a>
                                        <a onclick="confirm(this, <?php echo "3" . $row->getUserID() ?>)"><button class="btn btn-danger f">No</button></a>
                                    </div>
                                </div>
                            <?php
                            }
                            else
                            {
                                // display the details with the default photo
                                echo
                                // each line calls a method from UserDataDet class
                                '<div onclick="eliminate(this)" class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">'.
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">' . $row->getUserEmail() . '</a>'.'</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . $row->getFullName() . '</a>'.'</div>' .
                                    '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->getUserID().' ">'  . $row->getUsername() . '</a>'.'</div>' .
                                '<div class="row col-lg-2 notClickable">' .
                                        '<div class="col-lg-2 text-nowrap p-2 imgMain">' ?> <img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture"></a></div>
                                    </div>
                                    <div class="col-lg-2 notClickable fCont">
                                        <a class="yes" onclick="confirm(this, <?php echo "2" . $row->getUserID() ?>)"><button class="btn btn-success f">Yes</button></a>
                                        <a onclick="confirm(this, <?php echo "4" . $row->getUserID() ?>)"><button class="btn btn-danger f">No</button></a>
                                    </div>
                                </div>
                     <?php }
                        }
                    }
                    else
                    { ?>
                            <!-- div with table-responsive to make the table fluid -->
                            <div class="table-responsive notClickable">
                                <!-- if condition is false display this message -->
                                <h1 class="card-title m-b-0">There are no new Requests</h1>
                            </div>
                        </div>
                        <!-- div with justify-content-center to distribute contents equally -->
                        <div class="justify-content-center text-center notClickable cCont">
                            <!-- a with class name c in button to customise the button -->
                            <a href="../loggedInPage.php"><button class="c">Home</button></a>
                        </div>
                        <?php $_SESSION['notifyRequest'] = false; // assign false value to global variable 'notifyRequest?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
                    <?php require('template/footer.php'); // access the footer.php
                    exit(); // exit the script
                    } ?>
                    </div>
                    <!-- div with justify-content-center to distribute contents equally -->
                    <div class="justify-content-center text-center notClickable cCont">
                        <!-- a with class name c in button to customise the button -->
                        <a href="../loggedInPage.php"><button class="c">Home</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../Javascript/Loading.js"></script>
<script src="../Javascript/Requests.js"></script>
<script type="text/javascript">
</script>
<?php require('template/paginationRequests.php') // access the paginationRequests.php ?>
<?php require('template/footer.php') // access the footer.php ?>