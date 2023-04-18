let latitude = "";
let longitude = "";
let userDetails = "";
let map;
map = new OpenLayers.Map("Map"); // link to div
map.addLayer(new OpenLayers.Layer.OSM()); // create layer
let epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection idk
let projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
let lonLat = new OpenLayers.LonLat( longitude ,latitude ).transform(epsg4326, projectTo);
let zoom=10; // the zoom distance
map.setCenter (lonLat, zoom); // set the centre position
let vectorLayer = new OpenLayers.Layer.Vector("Overlay"); // instantiate OpenLayers
map.addLayer(vectorLayer); // add layer
let controls = { selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup }) };
map.addControl(controls['selector']); // add controls
controls['selector'].activate(); // activate controls

document.querySelector('#find-me').addEventListener('click', getImage); // event listener

setInterval(window.onload = function () { updateMe() }, 3500); // update about friends
setInterval(window.onload = function () { geoing() }, 3500); // update locaton

/**
 * to set up the details on the map
 */
function getImage()
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            geoFindMe();
            userDetails = this.responseText;
        }
    };
    xmlhttp.open("GET", "../../Ajax/getImage.php?token=" + token.getToken(), true);
    xmlhttp.send();
}

/**
 * to update the user location
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
        xmlhttp.open("GET", "../../Ajax/updateLatLon.php?location=" + updateLatLon + "&token=" + token.getToken(), true);
        xmlhttp.send();
    }
}

/**
 * to get user details on the map
 */
function geoFindMe()
{
    const status = document.querySelector('#status');
    const mapLink = document.querySelector('#map-link');

    mapLink.href = '';
    mapLink.textContent = '';

    function success(position)
    {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        lonLat = new OpenLayers.LonLat( longitude ,latitude ).transform(epsg4326, projectTo);
        zoom=10;
        map.setCenter (lonLat, zoom);
        // my details
        console.log("here");
        let feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( longitude, latitude ).transform(epsg4326, projectTo),
            {description: userDetails} ,
            {externalGraphic: '../API/maps/markerUser.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
        );
        updateLocation(latitude, longitude);
        vectorLayer.addFeatures(feature);
        status.textContent = 'your location here';
        getFriendsNumber();
        document.getElementById('find-me').disabled = true;
    }

    function error(error)
    {
        status.textContent = 'Unable to retrieve your location' + " " + error.code + " " + error.message;
    }

    if (!navigator.geolocation)
    {
        status.textContent = 'Geolocation is not supported by your browser';
    }
    else
    {
        status.textContent = 'Locating...';
        navigator.geolocation.getCurrentPosition(success, error);
    }
}

/**
 * to get the current location
 */
function geoing()
{
    navigator.geolocation.getCurrentPosition((position) => {
        latitude = position.coords.latitude; // assign latitude
        longitude = position.coords.longitude; // assign longitude
        console.log("geo - T");
    });
}

/**
 * display user details on the map
 */
function withOthers()
{
    // my details
    let feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point( longitude, latitude ).transform(epsg4326, projectTo),
        {description: userDetails} ,
        {externalGraphic: '../API/maps/markerUser.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );
    updateLocation(latitude, longitude); // to database update
    vectorLayer.addFeatures(feature);
}

/**
 * get details about friends on the map
 */
function updateMe()
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            vectorLayer.destroyFeatures();
            withOthers();
            let locations = JSON.parse(this.response);
            locations.forEach(function (obj)
            {
                let dirImage = "";
                // other users
                if(obj.image == null)
                {
                    dirImage = 'src="..\/images\/website\/images\/default.png" ';
                }
                else
                {
                    dirImage = 'src="..\/images\/users\/' + obj.image + '" ';
                }
                let feature = new OpenLayers.Feature.Vector(
                    new OpenLayers.Geometry.Point( obj.longitude, obj.latitude  ).transform(epsg4326, projectTo),
                    {description:'<div class="innerDetails"><a href=../Models/Core.php?user_ID_details=' + obj.user_ID + '>' + obj.full_name + '</a></div><img class="mapsImage"' + dirImage + 'height="50px" width="50px">'} ,
                    {externalGraphic: '../API/maps/marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
                );
                vectorLayer.addFeatures(feature);
            })
        }
        console.log("automated");
    };
    xmlhttp.open("GET", "../../Ajax/updateFriends.php?token=" + token.getToken(), true);
    xmlhttp.send();
}

/**
 * to create the pop up bubble
 * @param feature
 */
function createPopup(feature)
{
    feature.popup = new OpenLayers.Popup.FramedCloud("pop",
        feature.geometry.getBounds().getCenterLonLat(),
        null,
        '<div class="markerContent">'+feature.attributes.description+'</div>',
        null,
        true,
        function() { controls['selector'].unselectAll(); }
    );
    feature.popup.closeOnMove = true;
    map.addPopup(feature.popup);
}

/**
 * to close the pop up bubble
 * @param feature
 */
function destroyPopup(feature)
{
    feature.popup.destroy();
    feature.popup = null;
}

/**
 * get the number of friends on the map
 */
function getFriendsNumber()
{
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById('friendsOnline').innerText = 'Online friends: ' + parseInt(this.responseText);
        }
    };
    xmlhttp.open("GET", "../../Ajax/countOnlineFriends.php?token=" + token.getToken(), true);
    xmlhttp.send();
}