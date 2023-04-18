let frameBoxFriend = {}; // box containing users' details

/**
 * to remove or block friends
 * @param event
 * @param eventTwo
 */
function manageFriend(event, eventTwo)
{
    let userID = eventTwo.toString().substring(1, 12); // user ID
    let confirm = eventTwo.toString().substring(0, 1); // confirmation
    let xmlhttp = new XMLHttpRequest(); // instantiate XMLHttpRequest
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (confirm == 5 || confirm == 6) //remove friend
            {
                event.innerHTML = '<button class="btn btn-warning f disabled">Removed</button>';
                delay(500).then(() => frameBoxFriend.remove());
            }
            else if (confirm == 7 || confirm == 8) // block friend
            {
                event.innerHTML = '<button class="btn btn-danger f disabled">Blocked</button>';
                delay(500).then(() => frameBoxFriend.remove());
            }
        }
    };
    xmlhttp.open('GET', '../../Ajax/confirmationRequest.php?userID=' + userID + '&confirm=' + confirm + "&token=" + token.getToken(), true);
    xmlhttp.send();
}

/**
 * to eliminate the frame box containing user details
 * @param event
 */
function eliminateFriend(event)
{
    frameBoxFriend = event; // add frame box
}

/**
 * delay process
 * @param time
 * @returns {Promise<unknown>}
 */
function delay(time)
{
    return new Promise(resolve => setTimeout(resolve, time)); // delay
}