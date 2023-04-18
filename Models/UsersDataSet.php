<?php
if(!isset($_SESSION)) // if session is not started
{
    session_start(); // start session
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/help/help.php'); // access help.php once
require_once('UserDataSet.php'); // access UserDataSet.php once

/**
 * The class UsersDataSet extends UserDataSet.
 * It manages all interactions between the user and the database.
 */
Class UsersDataSet extends UserDataSet
{
    /**
     * the function constructor is used to call the superclass' constructor.
     * it takes no parameter.
     */
    public function __construct()
    {
        parent::__construct(); // call superclass' constructor
    }

    /**
     * the function register gets input from user.
     * it sanitises the inputs before storing into the database.
     * it prevents spammers to create accounts without human interaction.
     */
    public function register()
    {        
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        $credentials = [
            'bot' => trim($_POST['bot']),
            'email_address' => trim($_POST['email_address']),
            'full_name' => trim($_POST['full_name']),
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),
            'passwordRepeat' => trim($_POST['passwordRepeat']),
        ]; // create local array of $_POST inputs
        // if any of the inputs requires is empty
        if (isset($_POST['bot']) && $_POST['bot'] == '') // check if invisible textbook is empty
        {
            if (empty($credentials['email_address']) || empty($credentials['full_name']) || empty($credentials['username']) || empty($credentials['password']) ||empty($credentials['passwordRepeat']))
            {
                alert("register", "Please fill out all inputs"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (!filter_var($credentials['email_address'], FILTER_VALIDATE_EMAIL)) // if email is not valid
            {
                alert("register", "Invalid email"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (!preg_match("/^[a-zA-Z\s]*$/", $credentials['full_name'])) // if full name is not in correct format
            {
                alert("register", "Invalid full name"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (preg_match("/^[A-Za-z0-9]*\s/", $credentials['username'])) // if username contains whitespaces
            {
                alert("register", "Invalid username"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (strlen($credentials['password']) < 6) // if password is less than 6 characters
            {
                alert("register", "Invalid password"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if($credentials['password'] !== $credentials['passwordRepeat']) // if repeat password does not match password
            {
                alert("register", "Password don't match"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (parent::checkIfEmailTaken($credentials['email_address'])) // if email already exists
            {
                alert("register", "email already taken"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (parent::checkIfUsernameTaken($credentials['username'])) // if username already exists
            {
                alert("register", "username already taken"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT); // encrypt password
            if($_POST['humanVerification'] != $_SESSION['verificationCode']) // check if verification code matches
            {
                alert("checkFailed", "Human verification failed"); // call method alert()
                header("location: ../register.php"); // redirect to register page
                exit(); // exit the script
            }
            if (parent::registerUser($credentials)) // check if user has been successfully registered
            {
                $_SESSION['registeredEmail'] = $credentials['email_address'];
                header("location: ../login.php"); // redirect to login page
            }
            else
            {
                header("location: ../register.php"); // redirect to register page
                die("Something went wrong");  // exit the script with a message
            }
        }
        else
        {
            header("location: ../index.php"); // redirect to register page
            die("Spamming is not allowed");  // exit the script with a message
        }
    }

    public function registerAjax($fullName, $email, $username, $password, $passwordRepeat, $verification, $bot)
    {
        $_GET = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        $credentials = [
            'bot' => trim($bot),
            'email_address' => trim($email),
            'full_name' => trim($fullName),
            'username' => trim($username),
            'password' => trim($password),
            'passwordRepeat' => trim($passwordRepeat),
        ]; // create local array of $_POST inputs
        // if any of the inputs requires is empty
        if (isset($bot) && $bot == '') // check if invisible textbook is empty
        {
            if (empty($credentials['email_address']) || empty($credentials['full_name']) || empty($credentials['username']) || empty($credentials['password']) ||empty($credentials['passwordRepeat']))
            {
                echo "1"; // one field missing
                return false;
            }
            if (!filter_var($credentials['email_address'], FILTER_VALIDATE_EMAIL)) // if email is not valid
            {
                echo "2"; // incorrect email
                return false;
            }
            if (!preg_match("/^[a-zA-Z\s]*$/", $credentials['full_name'])) // if full name is not in correct format
            {
                echo "3"; // incorrect name
                return false;
            }
            if (preg_match("/^[A-Za-z0-9]*\s/", $credentials['username'])) // if username contains whitespaces
            {
                echo "4"; // incorrect username
                return false;
            }
            if (strlen($credentials['password']) < 6) // if password is less than 6 characters
            {
                echo "5"; // incorrect password < 6
                return false;
            }
            if($credentials['password'] !== $credentials['passwordRepeat']) // if repeat password does not match password
            {
                echo "6"; // incorrect password matching
                return false;
            }
            if (parent::checkIfEmailTaken($credentials['email_address'])) // if email already exists
            {
                echo "7"; // email already taken
                return false;
            }
            if (parent::checkIfUsernameTaken($credentials['username'])) // if username already exists
            {
                echo "8"; // username already taken
                return false;
            }
            $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT); // encrypt password
            if($verification != $_SESSION['verificationCode']) // check if verification code matches
            {
                echo "9"; // human verification failed
                return false;
            }
            if (parent::registerUser($credentials)) // check if user has been successfully registered
            {
                $_SESSION['registeredEmail'] = $credentials['email_address'];
                //header("location: ../login.php"); // redirect to login page
                echo "0"; // success
                return true;
            }
            else
            {
                echo "10"; // something went wrong
                return false;
            }
        }
        else
        {
            echo "11"; // something went wrong
            return false;
        }
    }

    /**
     * the function login gets input from user.
     * it sanitises the inputs before storing into the database.
     */
    public function login()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        $_SESSION['userLoggingIn'] = $_POST['emailAddress']; // assign email
        $credentials = [
            'emailAddress' => trim($_POST['emailAddress']),
            'password' => trim($_POST['password'])
        ]; // create local array of $_POST inputs
        if (empty($credentials['emailAddress']) || empty($credentials['password'])) // if email or password input is empty
        {
            alert("login", "Please fill out all inputs"); // call method alert()
            header("location: ../login.php"); // redirect to register page
            exit(); // exit the script
        }
        if(filter_var($credentials['emailAddress'], FILTER_VALIDATE_EMAIL)) // if email is valid
        {
            if (parent::checkIfEmailTaken($credentials['emailAddress'])) // if user is registered in the database
            {

                $loggedInUser = $this->checkCredentials($credentials['emailAddress'], $credentials['password']); // assign values
                if ($loggedInUser) // if it contains all the values
                {
                    $this->generateUserSession($loggedInUser); // create session for the user
                    header("location: ../loggedInPage.php"); // redirect to homepage 
                }
                else
                {
                    alert("login", "Password Incorrect"); // call method alert()
                    header("location: ../login.php"); // redirect to login page 
                    exit(); // exit the script
                }
            }
            else
            {
                alert("login", "Email incorrect"); // call method alert()
                header("location: ../login.php"); // redirect to login page 
                exit(); // exit the script
            }

        }
        else
        {
            alert("login", "Email validation failed"); // call method alert()
            header("location: ../login.php"); // redirect to login page 
            exit(); // exit the script
        }
    }

    public function loginAjax($email, $password)
    {
        $_GET = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        $credentials = [
            'emailAddress' => trim($email),
            'password' => trim($password)
        ]; // create local array of $_POST inputs
        if (empty($credentials['emailAddress']) || empty($credentials['password'])) // if email or password input is empty
        {
            alert("login", "Please fill out all inputs"); // call method alert()
            header("location: ../login.php"); // redirect to register page
            exit(); // exit the script
        }
        if(filter_var($credentials['emailAddress'], FILTER_VALIDATE_EMAIL)) // if email is valid
        {
            if (parent::checkIfEmailTaken($credentials['emailAddress'])) // if user is registered in the database
            {

                $loggedInUser = $this->checkCredentials($credentials['emailAddress'], $credentials['password']); // assign values
                if ($loggedInUser) // if it contains all the values
                {
                    $this->generateUserSessionAjax($loggedInUser); // create session for the user
                    echo "0"; // success
                    return true;
                }
                else
                {
                    echo "1"; // password incorrect
                    return false;
                }
            }
            else
            {
                echo "2"; // email incorrect
                return false;
            }
        }
        else
        {
            echo "3"; // email validation failed
            return false;
        }
    }


    /**
     * the function checkCredentials checks if users is registered.
     * it takes two parameters.
     */
    public function checkCredentials($email, $password)
    {
        $row = parent::checkIfEmailTaken($email); // call superclass' method to verify email

        if ($row == false) // if no email found
        {
            return false;
        }
        $hashedPassword = $row->password; // assign password
        if (password_verify($password, $hashedPassword)) // if password matches
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function generateUserSession to create session for the user.
     * it takes one parameter.
     */
    public function generateUserSession($loggedInUser)
    {
        $_SESSION['user_ID'] = $loggedInUser->user_ID; // assign user ID to global variable
        $_SESSION['emailAddress'] = $loggedInUser->email_address; // assign email to global variable
        $_SESSION['full_name'] = $loggedInUser->full_name; // assign full name to global variable
        $_SESSION['username'] = $loggedInUser->username; // assign username to global variable
        $_SESSION['image'] = $loggedInUser->image; // assign image to global variable
        //$this->notifyRequest(); // call local function to check for notifications
        parent::addLogged_in(); // call superclass' function to add the user into the logged_in table
        header("location: ../loggedInPage.php"); // redirect to homepage
    }

    public function generateUserSessionAjax($loggedInUser)
    {
        $_SESSION['user_ID'] = $loggedInUser->user_ID; // assign user ID to global variable
        $_SESSION['emailAddress'] = $loggedInUser->email_address; // assign email to global variable
        $_SESSION['full_name'] = $loggedInUser->full_name; // assign full name to global variable
        $_SESSION['username'] = $loggedInUser->username; // assign username to global variable
        $_SESSION['image'] = $loggedInUser->image; // assign image to global variable
        //$this->notifyRequest(); // call local function to check for notifications
        parent::addLogged_in(); // call superclass' function to add the user into the logged_in table
        //header("location: ../loggedInPage.php"); // redirect to homepage
    }

    /**
     * the function logout to log out the user.
     * it destroys all the sessions created.
     * it takes no parameters.
     */
    public function logout()
    {
        parent::clearLogged_in(); // remove user's details from logged_in table
        unset($_SESSION['user_ID']); // unset session
        unset($_SESSION['emailAddress']); // unset session
        unset($_SESSION['full_name']); // unset session
        unset($_SESSION['username']); // unset session
        unset($_SESSION['image']); // unset session
        unset($_SESSION['notifyRequest']); // unset session
        unset($_SESSION['searchText']); // unset session
        unset($_SESSION['checkTheAsc']); // unset session
        unset($_SESSION['pageNumbers']); // unset session
        unset($_SESSION['rows']); // unset session
        unset($_SESSION['outcomeDetails']); // unset session
        unset($_SESSION['rowsDetails']); // unset session
        unset($_SESSION['profileDetails']); // unset session
        unset($_SESSION['rowsProfileDetails']); // unset session
        unset($_SESSION['pageNumbersRequests']); // unset session
        unset($_SESSION['pageNumbersFriends']); // unset session
        unset($_SESSION['got_user_ID']); // unset session
        unset($_SESSION['checkIfGot']); // unset session
        unset($_SESSION['blocked']); // unset session
        unset($_SESSION['outcome']); // unset session
        unset($_SESSION['rows']); // unset session
        unset($_SESSION['checkTheDesc']); // unset session
        unset($_SESSION['checkTheBox']); // unset session
        unset($_SESSION['searchText']); // unset session
        unset($_SESSION['title']); // unset session
        unset($_SESSION['searchText']); // unset session
        unset($_SESSION['confirmRequest']); // unset session
        unset($_SESSION['remove_friend']); // unset session
        unset($_SESSION['block_friend']); // unset session
        unset($_SESSION['verificationCode']); // unset session
        unset($_SESSION['got_it']); // unset session
        unset($_SESSION['not_got_it']); // unset session
        unset($_SESSION['got_to_cancel']); // unset session
        unset($_SESSION['userSent']); // unset session
        session_destroy(); // destroy all the data from the session
        header("location: ../index.php"); // redirect to guest homepage
    }

    /**
     * the function uploadImage to upload an image.
     * it takes no parameters.
     */
    public function uploadImage()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_POST['uploadImage']) && (!$_FILES['image']['error'] == 4)) // if image is input and there is no image error equals to 4
        {
            $aa =  $_FILES['image'];
            $file_name = $_FILES['image']['name']; // assign image name
            $file_temp = $_FILES['image']['tmp_name']; // assign temporary name
            $allowed_ext = array("jpeg", "jpg", "gif", "png", "JPG"); // assign allowed format
            $exp = explode(".", $file_name); // divide words using "." delimiter
            $ext = end($exp); // assign last word
            $path = "../images/users/" . $file_name; // assign path name
            if (in_array($ext, $allowed_ext)) // if the allowed format is matched
            {
                if (move_uploaded_file($file_temp, $path)) // if move the image to the path created
                {
                    if (parent::uploadUserImage($file_name, $path)) // if image was successfully uploaded to the database
                    {
                        $_SESSION['image'] = $path; // assign path name
                        header("location: ../loggedInPage.php"); // redirect to homepage
                    }
                    else
                    {
                        echo "something went wrong"; // output error message
                    }
                }
                else
                {
                    alert("upload", "The file . $exp . could not be uploaded"); // call method alert()
                    header("location: ../uploadImage.php"); // redirect to upload image page
                    exit(); // exit the script
                }
            }
            else
            {
                alert("upload", "The . $ext . extension cannot be used"); // call method alert()
                header("location: ../uploadImage.php"); // redirect to upload image page
                exit(); // exit the script
            }

        }
        else
        {
            alert("upload", "Please upload an image first"); // call method alert()
            header("location: ../uploadImage.php"); // redirect to upload image page
            exit(); // exit the script
        }
    }

    public function uploadImageAjax($path)
    {
        $ext = "";
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($path)) // if image is input and there is no image error equals to 4
        {
            $file_name = $_SESSION['username'].'.jpg';
                if (parent::uploadUserImage($file_name, $path)) // if image was successfully uploaded to the database
                {
                    $_SESSION['image'] = $path; // assign path name
                    //header("location: ../loggedInPage.php"); // redirect to homepage
                }
                else
                {
                    echo "something went wrong"; // output error message
                }
        }
        else
        {
            alert("upload", "Please upload an image first"); // call method alert()
            header("location: ../uploadImage.php"); // redirect to upload image page
            exit(); // exit the script
        }
    }

//    private function move($path)
//    {
//        $src = imagecreatefrompng($path);
//        $fr = "weeeee";
//    }


    private function compressPhoto($origin, $destination, $quality)
    {
        $photo = "";
        $details = getimagesize($origin);
        if ($details['mime'] == 'image/jpeg')
        {
            $photo = imagecreatefromjpeg($origin);
        }
        else if ($details['mime'] == 'image/gif')
        {
            $photo = imagecreatefromgif($origin);
        }
        else if ($details['mime'] == 'image/png')
        {
            $photo = imagecreatefrompng($origin);
        }
        if (imagejpeg($photo, $destination, $quality))
        {
            return true;
        }
        else
        {
            return false;
        }
    }



    /**
     * the function searchBoxProcess to search for a user.
     * it takes no parameters.
     */
    public function searchBoxProcess()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_POST['search'])) // if text search is set
        {
            $_SESSION['searchText'] = $_POST['look']; // assign text search to global variable
            $look = $_SESSION['searchText']; // assign text search to local variable
            if (parent::searchBox($look)) // if matches were found
            {
                $this->filterSearch(); // call local function
                if (isset($_SESSION['user_ID'])) // if user is logged in
                {
                    require('../searchLoggedIn.php'); // redirect to search result page
                }
                else
                {
                    require('../search.php'); // redirect to guest search result page
                }
                exit(); // exit the script
            }
        }
        else
        {
            header("location: ../register.php"); // redirect to register page
            die("Something went wrong");  // exit the script with a message
        }
    }

    /**
     * the function userDetails to view the user details.
     * it takes no parameters.
     */
    public function userDetails()
    {
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if(isset($_GET['user_ID_details']))
        {
            $_SESSION['got_user_ID'] = $user_ID_details = $_GET['user_ID_details']; // assign user ID details
            parent::showUserDetails($user_ID_details); // call superclass' function
            if(isset($_SESSION['outcomeDetails'])) // if user exists in the database
            {
                if($_SESSION['userSent'] == "normal") // if userSent equals to normal
                {
                    header("location: ../userDetails.php"); // redirect to user details
                }
                else
                {
                    header("location: ../userDetailsExtend.php"); // redirect to user details contain further conditions
                }

            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("User details could no be retrieved");  // exit the script with a message
            }

        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("User details could not be obtained");  // exit the script with a message
        }
    }
    /**
     * the function sendRequest to send friend request.
     * it takes no parameters.
     */
    public function sendRequest()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        if(parent::checkIfReceived() == false) // if user have not already sent a friendship requests
        {

            if(parent::checkIfSent() == false) // if request already sent
            {
                if (isset($_GET['sendRequest'])) // send request input is set
                {

                    $requestFriend = [
                        'user_sender' => trim($_SESSION['user_ID']),
                        'user_receiver' => trim($_SESSION['got_user_ID']),
                    ]; // create array with requester ID and receiver ID

                    if(parent::sendRequestUser($requestFriend)) // if request was successfully added into the database
                    {
                        header("location: ../confirmSent.php"); // redirect to confirmation page
                    }
                    else
                    {
                        echo "failed"; // output error message
                    }

                }
                else
                {
                    header("location: ../index.php"); // redirect to index page
                    die("something went wrong");  // exit the script with a message
                }
            }
            else
            {
                alert("checkSent", "You have already sent a friend request to the user."); // call method alert()
                header("location: ../userDetails.php"); // redirect to user details
                exit(); // exit the script
            }

        }
        else
        {
            alert("checkReceived", "The user have already sent you a friendship request."); // call method alert()
            header("location: ../requests.php"); // redirect to request list page
            exit(); // exit the script
        }
    }

    public function sendRequestAjax($userID)
    {
        //$this->notifyRequest(); // call local function to check for notifications
        if(parent::checkIfReceived() == false) // if user have not already sent a friendship requests
        {

            if(parent::checkIfSent() == false) // if request already sent
            {
                $requestFriend = [
                    'user_sender' => trim($_SESSION['user_ID']),
                    'user_receiver' => trim($userID),
                ]; // create array with requester ID and receiver ID

                if(parent::sendRequestUser($requestFriend)) // if request was successfully added into the database
                {
                    return "Sent";
                }
                else
                {
                    echo "Err_snt01"; // output error message
                }
            }
            else
            {
                alert("checkSent", "You have already sent a friend request to the user."); // call method alert()
                header("location: ../userDetails.php"); // redirect to user details
                exit(); // exit the script
            }
        }
        else
        {
            alert("checkReceived", "The user have already sent you a friendship request."); // call method alert()
            header("location: ../requests.php"); // redirect to request list page
            exit(); // exit the script
        }
    }

    /**
     * the function profile to view user profile.
     * it takes no parameters.
     */
    public function profile()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            $userID = [
                'user_ID_profile' => trim($_SESSION['user_ID']),
            ]; // create array of user ID
            parent::profileUser($userID); // call superclass' function to get user's details
            if (isset($_SESSION['profileDetails'])) // if user is in the database
            {
                header("location: ../profile.php"); // redirect to profile page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("Profile details could not be retrieved");  // exit the script with a message
            }
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("Profile details could not be obtained");  // exit the script with a message
        }
    }
    /**
     * the function requests to view request list.
     * it takes no parameters.
     */
    public function requests()
    {
        $_SESSION['userSent'] = "request"; // assign request
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            parent::requestsUser(); // get request list from the database
            header("location: ../requests.php"); // redirect to request list page
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("Something went wrong with the server");  // exit the script with a message
        }
    }
    /**
     * the function acceptRequest to accept friendship request.
     * it takes no parameters.
     */
    public function acceptRequest()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_GET['acceptRequest'])) // if input is accept request
        {
            $acceptFriend = [
                'friend_sender' => $_SESSION['got_it'], // ID of the friendship requester
                'friend_receiver' => $_SESSION['user_ID']
            ]; // create array of user ID and requester ID
            if(parent::acceptUserRequest($acceptFriend)) // if accept request was successfully added into the database
            {
                $_SESSION['confirmRequest'] = "yes"; // assign "yes"
                header("location: ../confirmRequest.php"); // redirect to confirmation page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("failed to accept the request");  // exit the script with a message
            }
        }
    }

    public function acceptRequestAjax($userID)
    {
        $acceptFriend = [
            'friend_sender' => $userID, // ID of the friendship requester
            'friend_receiver' => $_SESSION['user_ID']
        ]; // create array of user ID and requester ID
        if(parent::acceptUserRequest($acceptFriend)) // if accept request was successfully added into the database
        {
            return "Accepted";
        }
        else
        {
            return "Err_Acp01";  // exit the script with a message
        }
    }

    /**
     * the function refuseRequest to refuse friendship request.
     * it takes no parameters.
     */
    public function refuseRequest()
    {
//        $this->notifyRequest(); // call local function to check for notifications
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_GET['refuseRequest'])) // if input is refuse request
        {
            $refuseFriend = [
                'friend_sender' => $_SESSION['not_got_it'], // ID of the friendship requester
                'friend_receiver' => $_SESSION['user_ID']
            ]; // create array of user ID and requester ID
            if(parent::refuseUserRequest($refuseFriend)) // if refuse request was successfully added into the database
            {
                $_SESSION['confirmRequest'] = "no"; // assign "no"
                header("location: ../confirmRequest.php"); // redirect to confirmation page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("failed to decline the request");  // exit the script with a message
            }
        }
    }

    public function refuseRequestAjax($userID)
    {
        $refuseFriend = [
            'friend_sender' => $userID, // ID of the friendship requester
            'friend_receiver' => $_SESSION['user_ID']
        ]; // create array of user ID and requester ID
        if(parent::refuseUserRequest($refuseFriend)) // if refuse request was successfully added into the database
        {
            return "Refused";
        }
        else
        {
            return "Err_Rfd01";  // exit the script with a message
        }
    }

    /**
     * the function friends to view friend list.
     * it takes no parameters.
     */
    public function friends()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        $_SESSION['userSent'] = "friend"; // assign "friend"
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            parent::friendsUser(); // get friend list from the database
            header("location: ../friends.php"); // redirect to friend list page
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("friend list could not be obtained");  // exit the script with a message
        }
    }
    /**
     * the function filterSearch to filter search.
     * it takes no parameters.
     */
    public function filterSearch()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (!empty($_POST['filterSearch']) || isset($_POST['search'])) // if filter is not empty or text is available
        {
            if(isset($_POST['choose'])) // if radio option is used
            {
                if ($_POST['choose'] == 'asc' && empty($_SESSION['checkTheAsc'])) // if radio option is "asc"
                {
                    unset($_SESSION['checkTheDesc']); // unset desc
                    if(parent::filterAsc())
                    {
                        if (isset($_POST['online'])) // if check box online is checked
                        {
                            parent::filterOnlineAsc(); // call superclass' function to get online users in ascending order
                        }
                        else
                        {
                            unset($_SESSION['checkTheBox']); // unset check box
                        }
                        $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
                    }
                    else
                    {
                        header("location: ../index.php"); // redirect to index page
                        die("failed to use 'Asc' filter");  // exit the script with a message
                    }
                }
                else if ($_POST['choose'] == 'desc' && empty($_SESSION['checkTheDesc'])) // if radio option is "desc"
                {
                    unset($_SESSION['checkTheAsc']); // unset asc
                    if(parent::filterDesc()) // if superclass' function returned more than 0 rows
                    {
                        if(isset($_POST['online'])) // if checkbox online is checked
                        {
                            parent::filterOnlineDesc(); // call superclass' function to get online users in descending order
                        }
                        else
                        {
                            unset($_SESSION['checkTheBox']); // unset checkbox
                        }
                        $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
                    }
                    else
                    {
                        header("location: ../index.php"); // redirect to index page
                        die("failed to use 'Desc' filter");  // exit the script with a message
                    }
                }
                else if(isset($_POST['online'])) // if checkbox online is checked
                {
                    if(isset($_SESSION['checkTheAsc'])) // if radio option "asc" is clicked
                    {
                        parent::filterOnlineAsc(); // call superclass' function to show online users in ascending order
                    }
                    else if(isset($_SESSION['checkTheDesc'])) // if radio option "desc" is clicked
                    {
                        parent::filterOnlineDesc(); // call superclass' function to show online users in descending order
                    }
                    else
                    {
                        unset($_SESSION['checkTheBox']); // unset check box
                    }
                    $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
                }
                else
                {
                    unset($_SESSION['checkTheAsc']); // unset asc
                    unset($_SESSION['checkTheDesc']); // unset desc
                    unset($_SESSION['checkTheBox']); // unset checkbox
                    parent::searchBox($_SESSION['searchText']); // call superclass' function to do a normal search
                    $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
                }
            }
            else if ($_POST['online']) // if checkbox online is checked
            {
                if(parent::filterOnline()) // call superclass' function to check if returns more than 0 rows
                {
                    $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
                }
                else
                {
                    header("location: ../index.php"); // redirect to index page
                    die("failed to use 'Online' filter");  // exit the script with a message
                }
            }
            else
            {
                unset($_SESSION['checkTheAsc']); // unset asc
                unset($_SESSION['checkTheDesc']); // unset desc
                unset($_SESSION['checkTheBox']); // unset checkbox
                parent::searchBox($_SESSION['searchText']); // call superclass' function to do a normal search
                $this->checkIfLoggedSearchOrSearch(); // call local function to check if user is logged in or not
            }
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("the filter failed");  // exit the script with a message
        }
    }
    /**
     * the function checkIfLoggedSearchOrSearch to check if user is logged in.
     * it takes no parameters.
     */
    private function checkIfLoggedSearchOrSearch()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            header("location: ../searchLoggedIn.php"); // redirect to search result page
            exit(); // exit the script
        }
        else
        {
            header("location: ../search.php"); // redirect to guest search result page
            exit(); // exit the script
        }
    }

//    /**
//     * the function notifyRequest to check for notifications.
//     * it takes no parameters.
//     */
//    public function notifyRequest(): bool
//    {
//        if(!empty(parent::requestsUser())) // call superclass' function to check if request list is not empty
//        {
//            return $_SESSION['notifyRequest'] = true; // assign true
//        }
//        else
//        {
//            return $_SESSION['notifyRequest'] = false; // assign true
//        }
//    }
    /**
     * the function checkifHuman to verify if user is not a robot.
     * it prevents spamming as it requires human interaction.
     * it takes no parameters.
     */
    public function checkifHuman(): string
    {
        $size = 6; // size of the text verification
        $charSet = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; // all possible characters in the text
        $charSize = strlen($charSet); // measure the length of the charSet
        $randText = "";
        for ($i = 0; $i < $size; $i++) // for loop to add a random digit from the charSet
        {
            $randText .= $charSet[rand(0,$charSize - 1)]; // add a random digit within the length of the string
        }
        return $_SESSION['verificationCode'] = $randText; // return and assign the randomly generated text to global variable
    }
    /**
     * the function requestsSent to view requests sent list.
     * it takes no parameters.
     */
    public function requestsSent()
    {
        // $this->notifyRequest(); // call local function to check for notifications
        $_SESSION['userSent'] = "sent"; // assign "sent"
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            parent::requestsSentUser(); // call superclass' function to get list of users to whom the requests is sent
            header("location: ../requestsSent.php"); // redirect to requests sent list
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("requests sent list could not be obtained");  // exit the script with a message
        }
    }
    /**
     * the function cancelRequest to cancel requests sent.
     * it takes no parameters.
     */
    public function cancelRequest()
    {
        // $this->notifyRequest(); // call local function to check for notifications
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_GET['cancelRequest'])) // if cancel request is input
        {
            $cancelRequest = [
                'user_to_cancel' => $_SESSION['got_to_cancel'],
                'my_ID' => $_SESSION['user_ID']
            ]; // create array of user ID and cancel request ID
            if(parent::cancelRequestUser($cancelRequest))
            {
                header("location: ../confirmCancellation.php"); // redirect to confirmation page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("failed to cancel the request");  // exit the script with a message
            }
        }
    }

    public function cancelRequestAjax($userID)
    {
        $cancelRequest = [
            'user_to_cancel' => $userID,
            'my_ID' => $_SESSION['user_ID']
        ]; // create array of user ID and cancel request ID
        if(parent::cancelRequestUser($cancelRequest))
        {
            return "Cancelled";
        }
        else
        {
            return "Err_Cnd01";  // exit the script with a message
        }
    }

    /**
     * the function removeFriend to remove friend.
     * it takes no parameters.
     */
    public function removeFriend()
    {
        // $this->notifyRequest(); // call local function to check for notifications
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_GET['removeFriend'])) // if remove friend is input
        {
            $removeFriend = [
                'remove_friend' => $_SESSION['remove_friend'],
                'my_ID' => $_SESSION['user_ID']
            ]; // create array of user ID and remove friend ID
            if(parent::removeFriendUser($removeFriend)) // call superclass' function to check if the friend is removed
            {
                header("location: ../confirmRemoval.php"); // redirect to confirmation page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("failed to remove the friend");  // exit the script with a message
            }
        }
    }

    public function removeFriendAjax($userID)
    {
        $removeFriend = [
            'remove_friend' => $userID,
            'my_ID' => $_SESSION['user_ID']
        ]; // create array of user ID and remove friend ID
        if(parent::removeFriendUser($removeFriend)) // call superclass' function to check if the friend is removed
        {
            return "Removed";
        }
        else
        {
            return "Err_Rmd01";  // exit the script with a message
        }
    }

    /**
     * the function blockFriend to block a friend.
     * it takes no parameters.
     */
    public function blockFriend()
    {
        // $this->notifyRequest(); // call local function to check for notifications
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); // sanitise all $_POST inputs
        if (isset($_GET['blockFriend'])) // if block friend is input 
        {
            $blockFriend = [
                'block_friend' => $_SESSION['block_friend'],
                'my_ID' => $_SESSION['user_ID']
            ]; // create array of user ID and block friend ID
            if(parent::blockFriendUser($blockFriend)) // call superclass' function to check if the friend is blocked
            {
                header("location: ../confirmBlock.php"); // redirect to confirmation page
            }
            else
            {
                header("location: ../index.php"); // redirect to index page
                die("failed to block the friend");  // exit the script with a message
            }
        }
    }

    public function blockFriendAjax($userID)
    {
        $blockFriend = [
            'block_friend' => $userID,
            'my_ID' => $_SESSION['user_ID']
        ]; // create array of user ID and block friend ID
        if(parent::blockFriendUser($blockFriend)) // call superclass' function to check if the friend is blocked
        {
            return "Blocked";
        }
        else
        {
            return "Err_Bld01";  // exit the script with a message
        }
    }

    public function trackFriends()
    {
        //$this->notifyRequest(); // call local function to check for notifications
        if(isset($_SESSION['user_ID'])) // if user is logged in
        {
            header("location: ../trackFriends.php"); // redirect to requests sent list
        }
        else
        {
            header("location: ../index.php"); // redirect to index page
            die("Maps could not be loaded");  // exit the script with a message
        }
    }
}