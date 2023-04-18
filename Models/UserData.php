<?php
if(!isset($_SESSION)) // if session is not set
{
    session_start(); // start session
}
/**
 * The class UserData manages receives details about each user.
 * Each detail can be displayed using the getter method.
 */
class UserData implements JsonSerializable
{
    public $id, $email_address, $full_name, $username, $photoName, $latitude, $longitude /* $password */
    ;
    /**
     * @var mixed
     */
    /**
     * @var Database
     */
    /**
     * construct the object UserData.
     * constructor function receivers array from database.
     * generate multiple objects, which hold details from specific rows.
     */
    public function __construct($row)
    {
        $this->id = $row['user_ID']; // assign used ID
        $this->email_address = $row['email_address']; // assign email address
        $this->full_name = $row['full_name']; // assign full name
        $this->username = $row['username']; // assign username
        $this->photoName = $row['image']; // assign image
        if (isset($row['latitude'])) { $this->latitude = $row['latitude']; };
        if (isset($row['longitude'])) { $this->longitude =  $row['longitude']; };
        // $this->password = $row['password']; //assign password // not in use for security
    }

    /**
     * jsonSerialize function to serialise each variable
     * @return array
     */
    public function jsonSerialize() // straight line of json
    {
        return [
            'user_ID' => $this->id,
            'email_address' => $this->email_address,
            'full_name' => $this->full_name,
            'image' => $this->photoName,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /**
     * getter function to get the user ID
     */
    public function getUserID()
    {
        return $this->id; // return user id
    }

    /**
     * getter function to get the email address
     */
    public function getUserEmail()
    {
        return $this->email_address; // return email address
    }

    /**
     * getter function to get the full name
     */
    public function getFullName()
    {
       return $this->full_name; // return full name
    }

    /**
     * getter function to get the username
     */
    public function getUsername()
    {
       return $this->username; // return username
    }

    /**
     * getter function to get the photo
     */
    public function getUserPhoto()
    {
       return $this->photoName; // return photo
    }

    /**
     * getter function to get the latitude
     */
    public function getLatitude()
    {
        return $this->latitude; // return photo
    }

    /**
     * getter function to get the longitude
     */
    public function getLongitude()
    {
        return $this->longitude; // return photo
    }

//     /**
//      * getter method to get the photo
//      */
//     public function getUserPassword()
//     {
//         return $this->password; // return password
//     }
}