let frameBoxRequest = {};

/**
 * to manage the friend requests
 * @param event
 * @param eventTwo
 */
function confirm(event, eventTwo)
{
    let userID = eventTwo.toString().substring(1, 12);
    let confirm = eventTwo.toString().substring(0, 1);
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            if (confirm == 1 || confirm == 2) // confirm request
            {
                console.log(event.nextSibling);
                event.innerHTML = '<button class="btn btn-success f disabled">Accepted</button>';
                delay(500).then(() => frameBoxRequest.remove());
            }
            else if (confirm == 3 || confirm == 4) // refuse request
            {
                event.innerHTML = '<button class="btn btn-danger f disabled">Refused</button>';
                delay(500).then(() => frameBoxRequest.remove());
            }
        }
    };
    xmlhttp.open('GET', '../../Ajax/confirmationRequest.php?userID=' + userID + '&confirm=' + confirm +'&token=' + token.getToken(), true);
    xmlhttp.send();
}

/**
 * to eliminate the frame box containing user details
 * @param event
 */
function eliminate(event)
{
    frameBoxRequest = event; // assign the frame box
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