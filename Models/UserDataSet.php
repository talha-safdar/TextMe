<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
require_once('Database.php'); // access Database.php once
require_once('UserData.php'); // access UserData.php once

/**
 * The class UserData manages the queries to the database.
 * Each function produces a specific query to the database server.
 */
class UserDataSet
{
    /**
     * @var Database
     */
    private $_dbHandle, $_dbInstance; // declare private variables

    /**
     * the constructor does not take parameters.
     * construct the object UserDataSet.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance(); // initialise variable _dbInstance
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); // initialise variable _dbHandle
    }

    /**
     * the function fetchAllUsers obtains all the users registered.
     * The implementation idea was copied from an online resource.
     */
    public function fetchAllUsers()
    {
        $dataSet = []; // initialise array
        $outputPerPage = 20; // number of items displayed per page
        // prepare query to get all rows from users table
        $statement = $this->_dbHandle->prepare("SELECT * FROM users"); 
        $statement->execute(); // execute the query
        $resultNumber = $statement->rowCount(); // assign the number of rows obtained
        $_SESSION['pageNumbers'] = ceil($resultNumber / $outputPerPage); // divide the number of rows by 20
        if (!isset($_GET['page']) || $_GET['page'] == "") // if page is not set or does not include any value
        {
            $page = 1; // assign 1 to variable
        }
        else
        {
            $page = $_GET['page']; // pass the $_GET variable to local variable $page
        }
        $currentFirstOutput = ($page - 1) * $outputPerPage; // to get the first output (($page-1) * 20)
        // prepare query to get all rows from users table with limit indicated by the arithmetical calculation
        $statementNew = $this->_dbHandle->prepare("SELECT * FROM users LIMIT " . $currentFirstOutput . ',' . $outputPerPage);
        $statementNew->execute(); // execute the query
        $statementNew->rowCount(); // get the number of rows obtained
        while ($row = $statementNew->fetch()) // loop on each row and pass value to variable $row
        {
            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
        }
        return $dataSet; // return array $dataSet
    }

    /**
     * the function registeruser adds the user details to the database.
     * it takes one parameter.
     */
    public function registerUser($credentials)
    {
        // prepare query to insert user details in to the users table
        $statement = $this->_dbHandle->prepare("INSERT INTO users (email_address, full_name, username, password) VALUES (:email_address, :full_name, :username, :password)");
        $statement->bindParam(':email_address', $credentials['email_address']); // bind email address 
        $statement->bindParam(':full_name', $credentials['full_name']); // bind full name
        $statement->bindParam(':username', $credentials['username']); // bind username
        $statement->bindParam(':password', $credentials['password']); // bind password
        if($statement->execute()) // if execution is successful
        {
            return true; 
        }
        else
        {
            return false;
        }
    }

    /**
     * the function checkIfEmailTaken obtains row with matching value.
     * it takes one parameter.
     */
    public function checkIfEmailTaken($email)
    {
        // prepare query to select row matching the parameter from users table
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE email_address = :email_address");
        $statement->bindParam(':email_address', $email); // bind email
        $statement->execute(); // execute query
        $row = $statement->fetch(PDO::FETCH_OBJ); // fetch row as object
        if ($statement->rowCount() > 0) // if row number is greater than 0
        {
            return $row; // return $row
        }
        else
        {
            return false;
        }
    }

    /**
     * the function checkUsername obtains row with matching value.
     * it takes one parameter.
     */
    public function checkIfUsernameTaken($username)
    {
        // prepare query to select row matching the parameter from users table
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(':username', $username); // bind username
        $statement->execute(); // execute query
        $row = $statement->fetch(PDO::FETCH_OBJ); // fetch row as object
        if ($statement->rowCount() > 0) // if row number is greater than 0
        {
            return $row; // return $row
        }
        else
        {
            return false;
        }
    }

    /**
     * the function addLogged_in adds the user login details in the database.
     * it takes no parameter.
     */
    public function addLogged_in()
    {
        // prepare query to insert user login details in to the loggedin_users table
        $statement = $this->_dbHandle->prepare("INSERT INTO loggedin_users (user_logged, date, time) VALUES (:user_ID, :date, :time)");
        $date = date("d/m/Y"); // assign date 
        $time =date("h:i"); // assign time
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->bindParam(':date', $date); // bind date
        $statement->bindParam(':time', $time); // bind time
        $statement->execute(); // execute query
    }

    /**
     * the function clearLogged_in deletes the user login details from the database.
     * it takes no parameter.
     */
    public function clearLogged_in()
    {
        // prepare query to delete user login details from to the loggedin_users table
        $statement = $this->_dbHandle->prepare("DELETE FROM loggedin_users WHERE user_logged = :user_ID");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
    }

    /**
     * the function uploadUserImage deletes the user login details from the database.
     * it takes two parameters.
     */
    public function uploadUserImage($file_name, $path)
    {
        // prepare query to add photo into users table
        $statement = $this->_dbHandle->prepare("UPDATE users SET image=:image, img_location=:loc WHERE user_ID=:id");
        $statement->bindParam(':image', $file_name); // bind image name
        $statement->bindParam('loc', $path); // bind path name
        $statement->bindParam(':id', $_SESSION['user_ID']); // bind user ID
        if ($statement->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function searchBox obtains all matching users.
     * it takes one parameter.
     */
    public function searchBox($look)
    {
        // prepare query to get users matching with the input
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :keyword OR username LIKE :key ORDER BY user_ID");
        $lookup = '%' . $look . '%'; // assign the $look variable with % for SQL
        $statement->bindParam(':keyword', $lookup); // assign search text
        $statement->bindParam(':key', $lookup); // assign search text
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch row as object
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        if ($_SESSION['outcome'] > 0) // if fetched objects are more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function searchBoxAjax obtains all matching users.
     * it takes one parameter.
     */
    public function searchBoxAjax($look)
    {
        $outcome = [];
        // prepare query to get users matching with the input
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :keyword OR username LIKE :key ORDER BY user_ID");
        $lookup = '%' . $look . '%'; // assign the $look variable with % for SQL
        $statement->bindParam(':keyword', $lookup); // assign search text
        $statement->bindParam(':key', $lookup); // assign search text
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch row as object
        if ($outcome > 0) // if fetched objects are more than 0
        {
            return $outcome;
        }
        else
        {
            return "No name found";
        }
    }

    /**
     * the function searchBoxAjaxAlt obtains all users.
     */
    public function searchBoxAjaxAlt()
    {
        $statement = $this->_dbHandle->prepare("SELECT user_ID, full_name, username, image FROM users");
        $statement->execute(); // execute query
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * the function showUserDetails obtains all matching users.
     * it takes one parameter.
     */
    public function showUserDetails($user_ID_details)
    {
        // prepare query to get one user with matchin user ID
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = :user_ID_details");
        $statement->bindParam(':user_ID_details', $user_ID_details); // bind user ID
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch row as object
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcomeDetails'] = $outcome; // assign to global variable
        $_SESSION['rowsDetails'] = $rows; // assign to global variable
        if ($_SESSION['outcomeDetails'] > 0) // if fetched objects are more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function sendRequestUser to insert users into table requests.
     * it takes one parameter.
     */
    public function sendRequestUser($requestFriend)
    {
        // prepare query to insert two users into the table requests
        $statement = $this->_dbHandle->prepare("INSERT INTO requests (user_sender , user_receiver) VALUES (:user_sender, :user_receiver)");
        $statement->bindParam(':user_sender', $requestFriend['user_sender']); // bind user sender
        $statement->bindParam(':user_receiver', $requestFriend['user_receiver']); // bind user receiver
        if ($statement->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function profileUser to obtain user information.
     * it takes one parameters.
     */
    public function profileUser($userID)
    {
        // prepare query to obtain user information
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = :user_ID_profile");
        $statement->bindParam(':user_ID_profile', $userID['user_ID_profile']); // bind user ID
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['profileDetails'] = $outcome; // assign to global variable
        $_SESSION['rowsProfileDetails'] = $rows; // assign to global variable
        if ($_SESSION['profileDetails'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function profileUserAjax to obtain user information.
     */
    public function profileUserAjax()
    {
        // prepare query to obtain user information
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = :user_ID");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
        return $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
    }

    /**
     * the function requestsUser to view request list.
     * it takes no parameters.
     */
    public function requestsUser()
    {
        $dataSet = []; // initialise array
        $outputPerPage = 20; // number of items displayed per page
        // prepare query to get all rows from users table matching user requests
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, latitude, longitude FROM  users WHERE user_ID = ANY (SELECT user_sender FROM requests WHERE user_receiver = :user_ID)");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
        $resultNumber = $statement->rowCount(); // assign the number of rows obtained
        $_SESSION['pageNumbersRequests'] = ceil($resultNumber / $outputPerPage); // divide the number of rows by 20
        if (!isset($_GET['page']) || $_GET['page'] == "") // if page is not set or does not include any value
        {
            $page = 1; // assign 1 to variable
        }
        else
        {
            $page = $_GET['page']; // pass the $_GET variable to local variable $page
        }
        $currentFirstOutput = ($page - 1) * $outputPerPage; // to get the first output (($page-1) * 20)
        // prepare query to get all rows from users table matching user requests with limit indicated by the arithmetical calculation
        $statementNew = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, latitude, longitude FROM  users WHERE user_ID = ANY (SELECT user_sender FROM requests WHERE user_receiver = :user_ID) LIMIT " . $currentFirstOutput . ',' . $outputPerPage);
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute the query
        $statementNew->rowCount(); // assign row count
        while ($row = $statementNew->fetch()) // loop on each row and pass value to variable $row
        {
            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
        }
        return $dataSet; // return array $dataSet
    }

    /**
     * the function requestsUserAjax to view request list.
     */
    public function requestsUserAjax()
    {
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, latitude, longitude FROM  users WHERE user_ID = ANY (SELECT user_sender FROM requests WHERE user_receiver = :user_ID)");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
        return $statement->rowCount();
    }

    /**
     * the function friendsUser to view friend list.
     * it takes no parameters.
     */
    public function friendsUser()
    {
        $dataSet = []; // initialise array
        $outputPerPage = 20; // number of items displayed per page
        // prepare query to get all rows from users table matching user friends
        $statement = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = ANY (SELECT friend_sender from friends where friend_receiver = :user_ID) OR user_ID = ANY  (SELECT friend_receiver from friends where friend_sender = :user_IDTwo)");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
        $resultNumber = $statement->rowCount(); // assign row count
        $_SESSION['pageNumbersFriends'] = ceil($resultNumber / $outputPerPage); // divide the number of rows by 20
        if (!isset($_GET['page']) || $_GET['page'] == "") // if page is not set or does not include any value
        {
            $page = 1; // assign 1 to variable
        }
        else
        {
            $page = $_GET['page']; // pass the $_GET variable to local variable $page
        }
        $currentFirstOutput = ($page - 1) * $outputPerPage; // to get the first output (($page-1) * 20)
        // prepare query to get all rows from users table matching user friends with limit indicated by the arithmetical calculation
        $statementNew = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = ANY (SELECT friend_sender from friends where friend_receiver = :user_ID) OR user_ID = ANY  (SELECT friend_receiver from friends where friend_sender = :user_IDTwo) LIMIT " . $currentFirstOutput . ',' . $outputPerPage);
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute query
        $statementNew->rowCount(); // assign row count
        while ($row = $statementNew->fetch()) // loop on each row and pass value to variable $row
        {
            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
        }
        return $dataSet; // return array $dataSet

    }

    /**
     * the function allFriendsAjax to get all friends.
     * @return array
     */
    public function allFriends()
    {
        $dataSet = [];
        $statementNew = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = ANY (SELECT friend_sender from friends where friend_receiver = :user_ID) OR user_ID = ANY  (SELECT friend_receiver from friends where friend_sender = :user_IDTwo)");
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute query
        $statementNew->rowCount(); // assign row count
        while ($row = $statementNew->fetch()) // loop on each row and pass value to variable $row
        {
            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
        }
        return $dataSet; // return array $dataSet
    }

    /**
     * the function allFriendsAjax to get the number of friends.
     * @return int
     */
    public function allFriendsAjax()
    {
        $statementNew = $this->_dbHandle->prepare("SELECT * FROM users WHERE user_ID = ANY (SELECT friend_sender from friends where friend_receiver = :user_ID) OR user_ID = ANY  (SELECT friend_receiver from friends where friend_sender = :user_IDTwo)");
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute query
        return $statementNew->rowCount(); // assign row count
    }

    /**
     * the function setLatLong to upload latitude and longitude.
     * it takes two parameters.
     * @param $lon
     * @param $lat
     * @return bool
     */
    public function setLatLong($lon, $lat)
    {
        $statement = $this->_dbHandle->prepare("UPDATE users SET latitude = :lat, longitude = :lon WHERE user_ID = :user_ID");
        $statement->bindParam(':lon', $lon); // bind receiver ID
        $statement->bindParam(':lat', $lat); // bind receiver ID
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind receiver ID
        if($statement->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function checkIfReceived to check if received request from the user.
     * it takes no parameters.
     */
    public function checkIfReceived()
    {
        // prepare query to get all rows from requests table matching user sender as the receiver and user receiver as uder ID
        $statementNew = $this->_dbHandle->prepare("SELECT user_receiver FROM requests WHERE user_sender = :got_user_ID AND user_receiver = :user_ID");
        $statementNew->bindParam(':got_user_ID', $_SESSION['got_user_ID']); // bind receiver ID
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute query
        $rows = $statementNew->rowCount(); // assign row count
        if ($rows > 0) // if row count is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function checkIfSent to check if sent request to the user.
     * it takes no parameters.
     */
    public function checkIfSent()
    {
        // prepare query to get all rows from requests table matching user sender as user ID and user receiver as the receiver
        $statementNew = $this->_dbHandle->prepare("SELECT user_receiver FROM requests WHERE user_sender = :user_ID AND user_receiver = :got_user_ID");
        $statementNew->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statementNew->bindParam(':got_user_ID', $_SESSION['got_user_ID']); // bind receiver ID
        $statementNew->execute(); // execute query
        $rows = $statementNew->rowCount(); // assign row count
        if ($rows > 0) // if row count is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function acceptUserRequest to accept a friendship request.
     * it takes one parameter.
     */
    public function acceptUserRequest($acceptUser)
    {
        // prepare query to insert data into table friends 
        $statement = $this->_dbHandle->prepare("INSERT INTO friends (friend_sender, friend_receiver) VALUE (:friend_sender, :friend_receiver)");
        $statement->bindParam(':friend_sender', $acceptUser['friend_sender']); // bind sender ID
        $statement->bindParam(':friend_receiver', $acceptUser['friend_receiver']); // bind receiver ID
        $statement->execute(); // execute query
        $rows = $statement->rowCount(); // assign row count

        // prepare query to delete data from table requests 
        $statement = $this->_dbHandle->prepare("DELETE FROM requests WHERE user_receiver = :friend_receiver AND user_sender = :friend_sender");
        $statement->bindParam(':friend_receiver', $acceptUser['friend_receiver']); // bind receiver ID
        $statement->bindParam(':friend_sender', $acceptUser['friend_sender']); // bind sender ID
        $statement->execute(); // execute the PDO statement
        if ($rows > 0) // if row count is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function refuseUserRequest to refuse a friendship request.
     * it takes one parameter.
     */
    public function refuseUserRequest($refuseUser)
    {
        // prepare query to delete data from table requests
        $statement = $this->_dbHandle->prepare("DELETE FROM requests WHERE user_receiver = :friend_receiver AND user_sender = :friend_sender");
        $statement->bindParam(':friend_receiver', $refuseUser['friend_receiver']); // bind receiver ID
        $statement->bindParam(':friend_sender', $refuseUser['friend_sender']); // bind sender ID
        if ($statement->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function alreadyFriends to check if user is already friend of a user.
     * it takes one parameter.
     */
    public function alreadyFriends()
    {
        $_SESSION['checkIfGot'] = []; // initialise global variable array
        if($this->requestsSentUserCheck()) // call local function to check if friend request was already sent
        {
            $_SESSION['checkIfGot'] = []; // initialise global variable array
            return $this->requestsSentUserCheck(); // return local function output
        }
        else if($this->checkIfBlocked() == true) // call local function to check if user is blocked
        {
            $_SESSION['checkIfGot'] = []; // initialise global variable array
            return $_SESSION['blocked'] = true; // return blocked as true
        }
        else
        {
            $_SESSION['sent'] = false;
            // preapre query to get all rows from table users matching values in table friends with the user ID
            $statement = $this->_dbHandle->prepare("SELECT user_ID FROM users WHERE user_ID = ANY (SELECT friend_sender from friends where friend_receiver = :user_ID) OR user_ID = ANY  (SELECT friend_receiver from friends where friend_sender = :user_IDTwo)");
            $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
            $statement->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
            $statement->execute(); // execute query
            $_SESSION['checkIfGot'] = []; // initialise global variable array
            while ($row = $statement->fetch()) // loop on each row and pass value to variable $row
            {
                $_SESSION['checkIfGot'][] = $row; // passeach row to global variable array
            }
            $user = array_column($_SESSION['checkIfGot'], 'user_ID'); // get matching IDs in the column and assign
            $_SESSION['checkIfGot'] = $user; // assign to global variable
            return $_SESSION['checkIfGot']; // return global variable array
        }

    }

    /**
     * the function filterAsc to filter in an ascending order.
     * it takes no parameter.
     */
    public function filterAsc()
    {
        // prepare query to get all rows from table users matching a value in ascending order
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :keyword OR username LIKE :key ORDER BY full_name ASC");
        $lookup = '%' . $_SESSION['searchText'] . '%'; // assign to local variable
        $statement->bindParam(':keyword', $lookup); // bind text search
        $statement->bindParam(':key', $lookup); // text search
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        $_SESSION['checkTheAsc'] = true; // assign true to global variable
        if ($_SESSION['outcome'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function filterDesc to filter in a descending order.
     * it takes no parameter.
     */
    public function filterDesc()
    {
        // prepare query to get all rows from table users matching a value in descending order
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :keyword OR username LIKE :key ORDER BY full_name DESC");
        $lookup = '%' . $_SESSION['searchText'] . '%'; // assign to local variable
        $statement->bindParam(':keyword', $lookup); // bind text search
        $statement->bindParam(':key', $lookup); // bind text search
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        $_SESSION['checkTheDesc'] = true; // assign true to global variable
        if ($_SESSION['outcome'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function filterOnline to filter online users.
     * it takes no parameter.
     */
    public function filterOnline()
    {
        // prepare query to get all rows from table users matching users in logged_in table
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :keyword AND user_ID = ANY (SELECT user_logged FROM loggedin_users, users WHERE  user_logged = user_ID)");
        $lookup = '%'.$_SESSION['searchText'].'%'; // assign to local variable
        $statement->bindParam(':keyword', $lookup); // bind text search
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        $_SESSION['checkTheBox'] = true; // assign true to global variable
        if ($_SESSION['outcome'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function filterOnlineAsc to filter online users in an ascending order.
     * it takes no parameter.
     */
    public function filterOnlineAsc()
    {
        // prepare query to get all rows from table users matching users in logged_in table in ascending order
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :key AND user_ID IN (SELECT user_logged FROM loggedin_users) ORDER BY full_name ASC");
        $lookup = '%'.$_SESSION['searchText'].'%'; // assign to local variable
        $statement->bindParam(':key', $lookup); // bind text search
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        $_SESSION['checkTheBox'] = true; // assign true to global variable
        if ($_SESSION['outcome'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function filterOnlineDesc to filter online users in a descending order.
     * it takes no parameter.
     */
    public function filterOnlineDesc()
    {
        // prepare query to get all rows from table users matching users in logged_in table in descending order
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image FROM users WHERE full_name LIKE :key AND user_ID IN (SELECT user_logged FROM loggedin_users) ORDER BY full_name DESC");
        $lookup =  '%' .$_SESSION['searchText']. '%'; // assign to local variable
        $statement->bindParam(':key', $lookup); // bind text search
        $statement->execute(); // execute query
        $outcome = $statement->fetchAll(PDO::FETCH_OBJ); // fetch rows as object and assign to local variable
        $rows = $statement->rowCount(); // assign row count
        $_SESSION['outcome'] = $outcome; // assign to global variable
        $_SESSION['rows'] = $rows; // assign to global variable
        $_SESSION['checkTheBox'] = true; // assign true to global variable
        if ($_SESSION['outcome'] > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function requestsSentUser to view requests sent list.
     * it takes no parameter.
     */
    public function requestsSentUser()
    {
        $dataSet = []; // initialise array
        $outputPerPage = 20; // number of items displayed per page
        // prepare query to get all rows from users table matching user requests as receiver
        $statement = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, img_location FROM  users WHERE user_ID = ANY (SELECT user_receiver FROM requests WHERE user_sender = :user_ID)");
        $statement->bindParam(':user_ID', $_SESSION['user_ID']); // bind user ID
        $statement->execute(); // execute query
        $resultNumber = $statement->rowCount(); // assign the number of rows obtained
        $_SESSION['pageNumbersRequests'] = ceil($resultNumber / $outputPerPage); // divide the number of rows by 20
        if (!isset($_GET['page']) || $_GET['page'] == "") // if page is not set or does not include any value
        {
            $page = 1; // assign 1 to variable
        }
        else
        {
            $page = $_GET['page']; // pass the $_GET variable to local variable $page
        }
        $currentFirstOutput = ($page - 1) * $outputPerPage; // to get the first output (($page-1) * 20)
        // prepare query to get all rows from users table matching user requests with limit indicated by the arithmetical calculation
        $statementNew = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, img_location FROM  users WHERE user_ID = ANY (SELECT user_receiver FROM requests WHERE user_sender = :user_IDTwo) LIMIT " . $currentFirstOutput . ',' . $outputPerPage);
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute the query
        $statementNew->rowCount(); // assign row count
        while ($row = $statementNew->fetch()) // loop on each row and pass value to variable $row
        {
            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
        }
        return $dataSet; // return array $dataSet
    }

    /**
     * the function requestsSentUserAjax to get the number of requests.
     * @return int
     */
    public function requestsSentUserAjax()
    {
        // prepare query to get all rows from users table matching user requests with limit indicated by the arithmetical calculation
        $statementNew = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, img_location FROM  users WHERE user_ID = ANY (SELECT user_receiver FROM requests WHERE user_sender = :user_IDTwo)");
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute the query
        return $statementNew->rowCount(); // assign row count
    }

    public function requestsSentUserCheck()
    {
        $dataSet = []; // initialise array
        $statementNew = $this->_dbHandle->prepare("SELECT user_ID, email_address, full_name, username, image, img_location FROM  users WHERE user_ID = ANY (SELECT user_receiver FROM requests WHERE user_sender = :user_IDTwo)");
        $statementNew->bindParam(':user_IDTwo', $_SESSION['user_ID']); // bind user ID
        $statementNew->execute(); // execute the query
        $statementNew->rowCount(); // assign row count
        //$outcome = $statementNew->fetchAll(PDO::FETCH_OBJ); // fetch row as object
        while ($row = $statementNew->fetchAll(PDO::FETCH_ASSOC)) // loop on each row and pass value to variable $row
        {
            $_SESSION['checkIfGot'][] = $row; // generate UserData object and pass to array $dataSet
        }
        return $_SESSION['checkIfGot']; // return array $dataSet
    }

    /**
     * the function cancelRequestUser to cancel a request.
     * it takes one parameter.
     */
    public function cancelRequestUser($cancelRequest)
    {
        // prepare query to delete row where user ID and receiver ID match
        $statement = $this->_dbHandle->prepare("DELETE FROM requests WHERE user_receiver =  :user_to_cancel  AND user_sender =  :my_ID");
        $statement->bindParam(':user_to_cancel', $cancelRequest['user_to_cancel']); // bind receiver ID
        $statement->bindParam(':my_ID', $cancelRequest['my_ID']); // bind user ID
        if ($statement->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function removeFriendUser to remove a friend.
     * it takes one parameter.
     */
    public function removeFriendUser($removeFriend)
    {
        // prepare query to delete row where friend ID and user ID match
        $statement = $this->_dbHandle->prepare("DELETE FROM friends WHERE friend_sender = :remove_friend AND friend_receiver = :my_ID OR friend_receiver = :remove_friendTwo AND friend_sender = :my_IDTwo");
        $statement->bindParam(':remove_friend', $removeFriend['remove_friend']); // bind friend ID
        $statement->bindParam(':my_ID', $removeFriend['my_ID']); // bind user ID
        $statement->bindParam(':remove_friendTwo', $removeFriend['remove_friend']); // bind friend ID
        $statement->bindParam(':my_IDTwo', $removeFriend['my_ID']); // bind user ID
        if ($statement->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function blockFriendUser to block a friend.
     * it takes one parameter.
     */
    public function blockFriendUser($blockFriend)
    {
        // prepare query to delete row where friend ID and user ID match
        $statement = $this->_dbHandle->prepare("DELETE FROM friends WHERE friend_sender = :remove_friend AND friend_receiver = :my_ID OR friend_receiver = :remove_friendTwo AND friend_sender = :my_IDTwo");
        $statement->bindParam(':remove_friend', $blockFriend['block_friend']); // bind friend ID
        $statement->bindParam(':my_ID', $blockFriend['my_ID']); // bind user ID
        $statement->bindParam(':remove_friendTwo', $blockFriend['block_friend']); // bind friend ID
        $statement->bindParam(':my_IDTwo', $blockFriend['my_ID']); // bind user ID
        $statement->execute(); // execute query
        // prepare query to add the removed row to table block_list
        $statementNew = $this->_dbHandle->prepare("INSERT INTO block_list (block_sender, block_receiver) VALUES (:my_ID, :removed_friend) ");
        $statementNew->bindParam(':my_ID', $blockFriend['my_ID']); // bind user ID
        $statementNew->bindParam(':removed_friend', $blockFriend['block_friend']); // bind friend ID
        if ($statementNew->execute()) // if execution of query is successful
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * the function checkIfBlocked to block a friend.
     * it takes one parameter.
     */
    private function checkIfBlocked()
    {
        // prepare query to obtain row where user ID and receiver ID match
        $statement = $this->_dbHandle->prepare("SELECT block_sender FROM users INNER JOIN block_list ON users.user_ID = block_list.block_sender AND block_list.block_receiver = :my_ID");
        $statement->bindParam(':my_ID', $blockFriend['user_ID']); // bind user ID
        $statement->execute(); // execute query
        if($statement->rowCount() > 0) // if fetched object is more than 0
        {
            return true;
        }
        else
        {
            return false;
        }
    }







    // from here generator functions begin



    /**
     * the function convertPasswordUser to convert passwords to hash.
     * It needs another script in the View file, which is not included.
     * it takes one parameter.
     */
//    public function convertPasswordUser($done) // generate hashed passwords
//    {
//        // prepare query to update rows where password and user ID match
//        $statement = $this->_dbHandle->prepare("UPDATE users SET password = :password WHERE user_ID = :id");
//        $statement->bindParam(':password', $done['pass']); // bind password
//        $statement->bindParam(':id', $done['user_ID']); // bind user ID
//        $statement->execute(); // execute query
//    }

    /**
     * the function fetchAllOfThem to get the list of users in one page.
     * it takes one parameter.
     */
//    public function fetchAllOfThem(): array // show all users on one page
//    {
//        // prepare query to obtain all users from table users
//        $statement = $this->_dbHandle->prepare("SELECT * FROM users");
//        $statement->execute(); // execute query
//        $dataSet = []; // initialise local variable array
//        while ($row = $statement->fetch()) // loop on each row and pass value to variable $row
//        {
//            $dataSet[] = new UserData($row); // generate UserData object and pass to array $dataSet
//        }
//        return $dataSet; // return array $dataSet
//    }

    /**
     * the function uploadGeneratedUsers to insert rows using a file.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedUsers($query): bool // generate users
//    {
//        // prepare query to insert into table users
//        $statement = $this->_dbHandle->prepare($query);
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    /**
     * the function uploadGeneratedImage to add image using a file.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedImage($file_name, $path, $id): bool // generate photos
//    {
//        // prepare query to add image in the rows
//        $statement = $this->_dbHandle->prepare("UPDATE users SET image=:image, img_location=:loc WHERE user_ID=:id");
//        $statement->bindParam(':image', $file_name); // bind image name
//        $statement->bindParam(':loc', $path); // bind path name
//        $statement->bindParam(':id', $id); // bind user ID
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    /**
     * the function uploadGeneratedFriends to insert users into table friends.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedFriends($line): bool // generate friends
//    {
//        // prepare query to insert users into table friends
//        $statement = $this->_dbHandle->prepare("INSERT INTO friends (friends_ID, friend_sender, friend_receiver) VALUES (:id, :first, :second)");
//        $statement->bindParam(':id', $_SESSION['count']); // bind first part of line (user ID)
//        $statement->bindParam(':first', $line['first']); // bind first part of line (user ID)
//        $statement->bindParam(':second', $line['second']); // bind second part of ine (user ID)
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    /**
     * the function uploadGeneratedRequests to insert users into table requests.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedRequests($line): bool // generate requests
//    {
//        // prepare query to insert users into table requests
//        $statement = $this->_dbHandle->prepare("INSERT INTO requests (request_ID, user_sender, user_receiver) VALUES (:id, :first, :second)");
//        $statement->bindParam(':id', $_SESSION['count']); // bind first part of line (user ID)
//        $statement->bindParam(':first', $line['first']); // bind first part of line (user ID)
//        $statement->bindParam(':second', $line['second']); // bind second part of ine (user ID)
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    /**
     * the function uploadGeneratedRequests to insert users into table requests.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedBlockedFriends($line): bool // generate block list
//    {
//        // prepare query to insert users into table block_list
//        $statement = $this->_dbHandle->prepare("INSERT INTO block_list (block_ID, block_sender, block_receiver) VALUES (:id, :first, :second)");
//        $statement->bindParam(':id', $_SESSION['count']); // bind first part of line (user ID)
//        $statement->bindParam(':first', $line['first']); // bind first part of line (user ID)
//        $statement->bindParam(':second', $line['second']); // bind second part of ine (user ID)
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }

    /**
     * the function uploadGeneratedLoggedInUsers to insert users into table loggedin_users.
     * It needs another script in the View file, which is not included.
     * each insert row is separated by line
     * it takes one parameter.
     */
//    public function uploadGeneratedLoggedInUsers($line) // generate block list
//    {
//        // prepare query to insert users into table block_list
//        $statement = $this->_dbHandle->prepare("INSERT INTO loggedin_users (loggedin_ID, user_logged, date, time) VALUES (:id, :first, :date, :time)");
//        $date = date("d/m/Y"); // assign date
//        $time =date("h:i"); // assign time
//        $statement->bindParam(':id', $_SESSION['count']); // bind first part of line (user ID)
//        $statement->bindParam(':first', $line); // bind first part of line (user ID)
//        $statement->bindParam(':date', $date); // bind date
//        $statement->bindParam(':time', $time); // bind time
//        if ($statement->execute()) // if execution of query is successful
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//    }
}