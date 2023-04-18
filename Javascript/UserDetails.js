let sendRequestBtn = document.getElementById("sendRequest");
let sendRequestInnerBtn = document.getElementById("sendRequestInner");
let senttBtn = document.getElementById("sentt");
let userID = "";
if (document.getElementById("userID") !== "")
{
    userID = document.getElementById("userID");
}
else
{
    userID = document.getElementById("userID1");
}
let confirm = 11;

/**
 * to send request dynamically
 */
function sendRequest() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            console.log("sent");
            sendRequestBtn.innerHTML = '<a><button class="c btnDisable" style="opacity: 0.5;">Request Sent</button></a> <a href="../loggedInPage.php"><button class="c">Home</button></a>';
            //sendRequestBtn.innerHTML = '<button class="c btnDisable">Request Sent</button>';
        }
    };
    xmlhttp.open('GET', '../../Ajax/confirmationRequest.php?userID=' + userID.textContent + '&confirm=' + confirm + "&token=" + token.getToken(), true);
    xmlhttp.send();
}
senttBtn.addEventListener("click", sendRequest, true);