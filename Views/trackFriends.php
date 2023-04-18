<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/Models/UserDataSet.php");
require_once('./help/help.php'); // access help.php once
require_once('template/header.php'); // access head.php once ?>
<body>
    <!-- div with class name container to contain contents -->
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
                            <?php
                            if (isset($_SESSION['user_ID']))
                            { ?>
                            <h5 class="card-title m-b-0 heading">Track your friends</h5>
                                <button id="find-me" class="c">Show my location</button>
                                <p id="status"></p>
                                <a id="map-link" target="_blank"></a>
                            <div class="d-flex justify-content-center align-items-center align-content-center border border-5 rounded-3">
                            <div class="w-100" id="Map" style="width:800px;height:600px"></div>
                            </div><?php
                            }
                            else
                            { ?>
                            <!-- div with table-responsive to make the table fluid -->
                            <div class="table-responsive">
                                <h1 class="card-title m-b-0">Something went wrong :(</h1> <?php
                            }
                            ?>
                        </div>
                        <!-- div with justify-content-center to distribute contents equally -->
                        <div class="justify-content-center text-center notClickable cCont">
                            <div id="friendsOnline"></div>
                             <!-- a with class name c in button to customise the button -->
                            <a href="../friends.php"><button class="c">Friends</button></a>
                             <!-- a with class name c in button to customise the button -->
                            <a href="../loggedInPage.php"><button class="c">Home</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/API/maps/application/OpenLayers.js"></script>
<script src="/Javascript/Maps.js"></script>

<?php require('template/footer.php') // access the footer.php ?>