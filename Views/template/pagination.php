<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
} ?>
<!--the pagination implementation is an idea copied from an online resource -->
<!-- nav with with class name navPagination to contain pagination -->
<nav id="pagination" class="navPagination notClickable">
    <!-- ul with class name pagination to contain pagination contents -->
    <ul class="pagination justify-content-center paginationChange">
        <!-- li with class name page-item to contain previous button -->
        <li class="page-item shadowPagPrev">
        <?php
        if($_SERVER['REQUEST_URI']) // if it has the URI to access the page
        {
            $page = $_SERVER['REQUEST_URI']; // assign to local variable
            $pageNo = preg_match('!\d+!', $page, $matches) ? $matches[0] : ''; // get the number from the URI and assign to local variable
            if (isset($_SESSION['user_ID'])) // if user is logged in
            {
                $lower = (int) $pageNo - 1; // decremenet $pageNo by one and cast to int to assign to $lower 
                if ($pageNo > 1) // if is greater than 1
                {
                    // use $lower vairable to reduce to go the previous page
                    echo '<a class="page-link" href="loggedInPage.php?page=' . $lower . '"' . 'tabindex="-1">Previous</a> ';
                }
                else
                {
                    // keep the same variable with the current value if is not more than 1
                    echo '<a class="page-link" href="loggedInPage.php?page=' . $pageNo . '"' . 'tabindex="-1">Previous</a>';
                }
            }
            else
            {
                $lower = (int) $pageNo - 1; // reduce $pageNo by one and cast to int to assign to $lower 
                if ($pageNo > 1) // if is greater than 1
                {
                    // use $lower variable to reduce to go the previous page
                    echo '<a class="page-link" href="index.php?page=' . $lower . '"' . 'tabindex="-1">Previous</a> ';
                }
                else
                {
                    // keep the same variable with the current value if is not more than 1
                    echo '<a class="page-link" href="index.php?page=' . $pageNo . '"' . 'tabindex="-1">Previous</a>';
                }
            }
        } ?>
        </li>
        <?php
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            if(isset($_SESSION['pageNumbers'])) // if global variable with page numbers is set
            {
                for($i=1; $i<=$_SESSION['pageNumbers']; $i++) // loop from to the maximum number of pages
                {
                    if ($i == (int) $pageNo) // if $i equals to $pageNo 
                    {
                        // display the matching value
                        echo '<li class="page-item shadowPagMid"><a class="page-link aPageItems" href="loggedInPage.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    else if ($i < (int) $pageNo-5 && $i != $_SESSION['pageNumbers']) // if $pageNo is greater than iterated value and not equal to pageNumbers
                    {
                        echo ""; // if condition met do not show right sided numbers
                    }
                    elseif ($i > (int) $pageNo+6 && $i != $_SESSION['pageNumbers']) // if $pageNo is lesser than iterated value and not equal to pageNumbers
                    {
                        echo ""; // if condition met do not show left sided numbers
                    }
                    else
                    {
                        // show other values that do not meet the above conditions
                        echo '<li class="page-item shadowPagMid"><a class="page-link" href="loggedInPage.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }
        }
        else
        {
            if(isset($_SESSION['pageNumbers'])) // if page numbers is set
            {
                for($i=1; $i<=$_SESSION['pageNumbers']; $i++) // loop from to the maximum number of pages
                {
                    if ($i == (int) $pageNo) // if $i equals to $pageNo 
                    {
                        // display the matching value
                        echo '<li class="page-item shadowPagMid"><a class="page-link aPageItems" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    else if ($i < (int) $pageNo-5 && $i != $_SESSION['pageNumbers']) // if $pageNo is greater than iterated value and not equal to pageNumbers
                    {
                        echo ""; // if condition met do not show right sided numbers
                    }
                    elseif ($i > (int) $pageNo+6 && $i != $_SESSION['pageNumbers']) // if $pageNo is lesser than iterated value and not equal to pageNumbers
                    {
                        echo ""; // if condition met do not show left sided numbers
                    }
                    else
                    {
                        // show other values that do not meet the above conditions
                        echo '<li class="page-item shadowPagMid"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
            }
        } ?>
        <!-- li with class name page-time to contain next button -->
        <li class="page-item shadowPagNext">
        <?php 
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            $higher = (int) $pageNo +1; // increment $pageNo by one and cast to int to assign to $higher 
            if ($pageNo < $_SESSION['pageNumbers']) // is $pageNo is less than page numbers
            {
                // use $higher variable to increase to go the next page
                echo  '<a class="page-link" href="loggedInPage.php?page=' . $higher . '"' . 'tabindex="-1">Next</a> ';
            }
            else
            {
                // keep the same variable with the current value if is not less than page number
                echo '<a class="page-link" href="loggedInPage.php?page=' . $_SESSION['pageNumbers'] . '"' . 'tabindex="-1">Next</a>';
            }

        }
        else
        {
            $higher = (int) $pageNo + 1; // increment $pageNo by one and cast to int to assign to $higher 
            if ($pageNo < $_SESSION['pageNumbers']) // is $pageNo is less than page numbers
            {
                // use $higher variable to increase to go the next page
                echo '<a class="page-link" href="index.php?page=' . $higher . '"' . 'tabindex="-1">Next</a> ';
            } 
            else 
            {
                // keep the same variable with the current value if is not less than page number
                echo '<a class="page-link" href="index.php?page=' . $_SESSION['pageNumbers'] . '"' . 'tabindex="-1">Next</a>';
            }
        } ?>
        </li>
    </ul>
</nav>