/**
 * the class UserButtons which extends GenerateToken
 * to get token and manage the buttons
 * "Requests", "Sent", and "Friends"
 */
class UserButtons extends GenerateToken
{
    constructor()
    {
        super();
        this.requests = document.getElementById('requestsButton');
        this.friends = document.getElementById('friendsButton');
        this.sent = document.getElementById('sentButton');
        this.requests.parameter = 1; // 1 = requests button
        this.friends.parameter = 2; // 2 = friends button
        this.sent.parameter = 3; // 3 = sent button
        this.requests.addEventListener("click", this.checkFriends);
        this.friends.addEventListener("click", this.checkFriends);
        this.sent.addEventListener("click", this.checkFriends);
    }

    /**
     * to check if there are users in the list
     * e.g. if not then show a message mentioning "no Friends"
     * @param look
     */
    checkFriends(look)
    {
        let button = look.currentTarget.parameter;
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                if (button === 1)
                {
                    if(this.responseText == 0)
                    {
                        document.getElementById('requestsButton').innerHTML = '<button class="btn-lg c dis">no requests</button>';
                        setTimeout(() => {
                            document.getElementById('requestsButton').innerHTML = '<button class="btn-lg c">Requests</button>';
                        }, 500); // Wait 3 seconds and then redirect.
                    }
                    else
                    {
                        window.location.href = "../Models/Core.php?requests=<?php $_SESSION['user_ID'] ?>";
                    }
                }
                else if(button == 2)
                {
                    if(this.responseText == 0)
                    {
                        document.getElementById('friendsButton').innerHTML = '<button class="btn-lg c dis">no friends</button>';
                        setTimeout(() => {
                            document.getElementById('friendsButton').innerHTML = '<button class="btn-lg c">Friends</button>';
                        }, 500); // Wait 3 seconds and then redirect.
                    }
                    else
                    {
                        window.location.href = "../Models/Core.php?friends=<?php $_SESSION['user_ID'] ?>";
                    }
                }
                else if(button == 3)
                {
                    if(this.responseText == 0)
                    {
                        document.getElementById('sentButton').innerHTML = '<button class="btn-lg c dis">no sends</button>';
                        setTimeout(() => {
                            document.getElementById('sentButton').innerHTML = '<button class="btn-lg c">Sent</button>';
                        }, 500); // Wait 3 seconds and then redirect.
                    }
                    else
                    {
                        window.location.href = "../Models/Core.php?requestsSent=<?php $_SESSION['user_ID'] ?>";
                    }
                }
            }
        };
        xmlhttp.open('GET', '../../Ajax/checkFriends.php?look=' +  button  + '&token=' + super.getToken(), true);
        xmlhttp.send();
    }
}