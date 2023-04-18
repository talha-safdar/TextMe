<?php
require('template/header.php'); // access header.php ?>
<body>
<div id="loading" class="loading">
    <div class="innerLoading"><img src="../images/website/images/Ripple-1s-200px%20(1).gif" height="200" width="200" alt="load" /></div>
</div>
    <!-- container for the sub-contents -->
    <div class="container containerTable">
        <!-- h3 with class name col-lg-e to allocate specific grid and display a message -->
        <h3 class="col-lg-3 welcome">Welcome Guest</h3>
        <!-- div with class name row to contain the contents -->
        <div class="row tableStyle">
            <!-- div with class name with column number limit -->
            <div class="col-md-12 tableCol">
                <!-- div with card name to create a card  -->
                <div class="card">
                    <!-- div with card-body to add contents inside -->
                    <div class="card-body text-center">
                        <!-- div with text-center to add contents inside -->
                        <div class="text-center">
                            <!-- p with a message -->
                            <p>Filter by:</p>
                            <!-- form with class name form to contain the contents to obtain inputs from the user -->
                            <form action="../Models/Core.php" method="post">
                                <!-- input to allow the user to interact -->
                                <input type="radio" id="" name="choose" value="asc" <?php if(isset($_SESSION['checkTheAsc'])) echo "checked='checked'"; // if variable is set then check the radio ?>>
                                <!-- label tp display the instructive text -->
                                <label for="friends">Asc (A-Z)</label>
                                <br>
                                <!-- input to allow the user to interact -->
                                <input type="radio" id="" name="choose" value="desc" <?php if(isset($_SESSION['checkTheDesc'])) echo "checked='checked'"; // if variable is set then check the radio ?>>
                                <!-- label tp display the instructive text -->
                                <label for="photo">Desc (Z-A)</label>
                                <br>
                                <!-- input to allow the user to interact -->
                                <input type="checkbox" id="" name="online" value="Online" <?php if(isset($_SESSION['checkTheBox'])) echo "checked='checked'"; // if variable is set then check the box ?>>
                                <!-- label tp display the instructive text -->
                                <label for="mutual">Online users</label>
                                <br>
                                <!-- input to allow the user to interact -->
                                <input type="submit" value="Submit" name="filterSearch">
                            </form>
                            <br>
                        </div>
                        <!-- h5 with card-title to display a text message -->
                        <h5 class="card-title m-b-0 heading">Users registered</h5>
                    </div>
                    <!-- div with table-responsive to make the table fluid -->
                    <div class="table-responsive">
                        <!-- div with class name row to contain the contents -->
                        <div class="row border rounder m-3 justify-content-around text-center overflow-hidden  headingNames">
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Full name</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">Username</div>
                            <!-- div with col-lg-2 to allocate specific grid -->
                            <div class="col-lg-2">photo</div>
                        </div>
                        <?php
                        if(!empty($_SESSION['outcome'])) // if global variable 'outcome' is not empty
                        {
                            foreach ($_SESSION['outcome'] as $row) // loop inside the variable to retrieve each data
                            {
                                if (!empty($row->image)) // if user has photo 
                                {
                                    // display details with the photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around  text-center overflow-hidden fontSize">'.
                                        '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">'  . $row->full_name. '</a>'.'</div>' .
                                        '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">'  . $row->username . '</a>'.'</div>' .
                                    '<div class="row col-lg-2 notClickable">' .
                                            '<div class="col-lg-2 text-nowrap p-2 imgMain">' . '<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">'  .  '<img class="profPic" src="../images/users/' .  $row->image . '" height="100px" width="100px" alt="profile picture">'.'</a>'.'</div>' .
                                        '</div>'.
                                    '</div>';
                                }
                                else
                                {
                                    // display the details with the default photo
                                    echo
                                    // each line calls a method from UserDataDet class
                                    '<div class="row border rounder m-3 justify-content-around text-center overflow-hidden fontSize">'.
                                        '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">'  . $row->full_name. '</a>'.'</div>' .
                                        '<div class="col-lg-2 text-nowrap text-truncate">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">'  . $row->username . '</a>'.'</div>' .
                                    '<div class="row col-lg-2 notClickable">' .
                                            '<div class="col-lg-2 text-nowrap p-2 imgMain">'.'<a class="clickUser" href="../Models/Core.php?user_ID_details='.$row->user_ID.' ">' . '<img class="profPic" src="../images/website/images/default.png" height="100px" width="100px" alt="profile picture">' . '</a>'.'</div>' .
                                        '</div>'.
                                    '</div>';
                                }
                            }
                        }
                        else
                        {
                            ?>
                            <!-- div with table-responsive to make the table fluid -->
                            <div class="table-responsive">
                                <!-- div with justify-content-center to distribute contents equally -->
                                <h1 class="justify-content-around text-center overflow-hidden p-3">There are no users returned</h1>
                            </div>
                        <?php } ?>
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