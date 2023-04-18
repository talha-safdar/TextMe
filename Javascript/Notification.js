/**
 * the class Notification to check for the notifications
 */
class Notification
{
    constructor()
    {
        this.generateNotification();
    }

    /**
     * to generate the notification
     * it changed the tab name, emits sound alert and adds a message on the screen
     */
    generateNotification()
    {
        let numberSound = 0;
        setInterval(window.onload = function ()
        {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    let link = document.getElementById('notPlace');
                    let notifyTab = document.getElementById("titleTab");
                    let favicon = document.getElementById("faviconChange");
                    if (this.responseText.split("  ")[0] > 0)
                    {
                        if(link != null)
                        {
                            link.style.visibility = 'visible';
                            link.className = "btn btn-success";
                            link.innerText = "You have" + " " + this.responseText.split("  ")[0] + " " + "friend request" ;
                            while(numberSound < 1)
                            {
                                audio.play() // play notification sound
                                numberSound++;
                            }
                        }
                        notifyTab.innerHTML = "";
                        notifyTab.innerHTML = "(" + this.responseText.split("  ")[0] + ") " + this.responseText.split("  ")[1];
                        favicon.href = "/images/website/favicon/faviconNoti.ico";
                        console.log("activated");
                    }
                    else
                    {
                        if(link !== null)
                        {
                            link.className = "";
                            link.innerText = "";
                            notifyTab.innerHTML = this.responseText.split("  ")[1];
                            favicon.href = "/images/website/favicon/favicon.ico";
                            console.log("deactivated");
                        }
                    }
                }
            };
            xmlhttp.open("GET", "../../Ajax/checkNotification.php?token=" + token.getToken(), true);
            xmlhttp.send();
        }, 5000);
    }
}