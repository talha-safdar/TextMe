<?php require_once('head.php'); // access head.php once?>
<header>
    <!-- nav with with class name navbar to contain navigation bar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <!-- container for the sub-contents -->
        <div class="container-fluid containerNav">
        <?php
        if(isset($_SESSION['user_ID'])) // if user is logged in
        { ?>
            <!-- use this a tag if user is logged to redirect to homepage -->
            <a class="navbar-brand logoBarOuter" href="../../loggedInPage.php"><img class="logoImg logoBar" src="../../images/website/images/logo.png" alt="logo"></a>
  <?php }
        else
        { ?>
            <!-- use this a tag to redirect to guest homepage -->
            <a class="navbar-brand logoBarOuter" href="../../index.php"><img class="logoImg logoBar" src="../../images/website/images/logo.png" alt="logo"></a>
  <?php } ?>
            <!-- form with class name form to contain the contents to obtain inputs from the user -->
            <form class="d-inline-flex d-flex justify-content-center formNav" action="../../Models/Core.php" method="post">
                <?php
                $link_array = explode('/',$link = $_SERVER['PHP_SELF']);
                $page = explode(".", end($link_array))[0];
                if ($page == "index" || $page == "loggedInPage" || $page == "search" || $page == "searchLoggedIn")
                {
                    ?>
                <!-- input to allow the user to interact. the text box preserves the text wrote by the user using global variable -->
                <div class="d-flex">

                <input id="searchTerm" class="form-control my-2 my-0" type="text" placeholder="Search by name..." name="look" <?php if(!empty($_SESSION['searchText'])) echo "value=".'"'.$_SESSION['searchText'].'"'.""; else { "value=".null; }?>>
                    <div id="clearSearch" class="clearBox"><div class="inClear"></div></div>
                    <div id="searchCool" class="position-absolute"><span id="searchSuggestion"></span></div>
                <button onclick="return validate()" id="searchButton" class="btn btn-secondary my-2 my-0 searchButton" type="submit" value="submit" name="search">Search</button>
                </div>
                <?php
                }
                ?>
                <!-- div with class name btn for the login/logout button -->
                <div class="btn my-lg-0 userButtonCover" id="navbarColor02">
                <?php
                if ($page != "register")
                {


                if(!isset($_SESSION['user_ID']))  // if user is not logged in
                    { ?>
                    <!-- display login if user is not logged in -->
<!--                    <a id="login" class="userButton" href="../../login.php">Login</a>-->
                    <a id="login" class="userButton">Login</a>
          <?php }
                else
                {?>
                    <!-- display Logout if user is logged in -->
                    <a id="logout" class="userButton" href="../../Models/Core.php?exit=logout">Logout</a>
                    <?php }
                } ?>
                </div>
            </form>
        </div>
    </nav>
</header>

<?php
if ($page == "index" || $page == "search" || $page == "searchLoggedIn")
{
?>
<script src="../../Javascript/GenerateToken.js"></script>
<script src="../../Javascript/SearchSystem.js"></script>
<script src="../../Javascript/SearchSystemExtended.js"></script>
<script src="../../Javascript/QueueDS.js"></script>
<script type="text/javascript">
let queue = new QueueDS;
let search = new SearchSystem;
</script>
<?php
}
else if ($page == "register")
{ ?>
    <script src="../../Javascript/GenerateToken.js"></script>
<?php
    }
else if ($page == "loggedInPage")
{?>
    <script src="../../Javascript/SearchSystem.js"></script>
    <script src="../../Javascript/SearchSystemExtended.js"></script>
    <script src="../../Javascript/QueueDS.js"></script>
    <script type="text/javascript">
        let queue = new QueueDS;
        let search = new SearchSystem;
    </script>
<?php
}
?>
<script type="text/javascript">
function validate()
{
    if(document.getElementById('searchTerm').value == "")
    {
        alert("Please enter something first");
        return false;
    }
    else
    {
        return true;
    }
}
</script>