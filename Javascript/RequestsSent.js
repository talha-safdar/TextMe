let frameBoxSent = {};

/**
 * to manage the sent requests
 * @param event
 * @param eventTwo
 */
function cancelRequest(event, eventTwo)
{
    console.log(eventTwo);
    let userID = eventTwo.toString().substring(1, 12);
    let confirm = eventTwo.toString().substring(0, 1);
    console.log(confirm);
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            //console.log(event);
            //console.log(confirm);
            if (confirm == 9 || confirm == 10) // cancel request sent
            {
                //console.log(event.nextSibling);
                event.innerHTML = '<button class="btn btn-warning f disabled">Cancelled</button>';
                delay(500).then(() => frameBoxSent.remove());
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
function eliminateSent(event)
{
    frameBoxSent = event;
    console.log(event);
}

/**
 * delay process
 * @param time
 * @returns {Promise<unknown>}
 */
function delay(time)
{
    return new Promise(resolve => setTimeout(resolve, time));
}