let latitude = "";
let longitude = "";

/**
 * to upload new location to the database
 * @param latitude
 * @param longitude
 */
function updateLocation(latitude, longitude)
{
    let xmlhttp = new XMLHttpRequest();
    let updateLatLon = latitude + " " + longitude;
    update(updateLatLon);
    function update(updateLatLon)
    {
        xmlhttp.onreadystatechange = function()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                console.log(this.responseText);
            }
        };
        xmlhttp.open("POST", "../../Ajax/updateLatLon.php?location=" + updateLatLon + "&token=" + token.getToken(), true);
        xmlhttp.send();
    }
}

/**
 * access user location
 */
function geoFindMe()
{
    const status = document.querySelector('#status');
    const mapLink = document.querySelector('#map-link');

    mapLink.href = '';
    mapLink.textContent = '';

    function success(position)
    {
        updateLocation(latitude, longitude); // upload the location to the database
    }
    function error(error)
    {
        alert("location could not be obtained");
    }

    if (!navigator.geolocation)
    {
        status.textContent = 'Geolocation is not supported by your browser';
    }
    else
    {
        status.textContent = 'Locating...';
        navigator.geolocation.getCurrentPosition(success, error); // get current position
    }
}