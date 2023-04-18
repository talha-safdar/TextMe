/**
 * the class SearchSystem which extends GenerateToken
 * serves for the dynamic search system
 */
class SearchSystem extends GenerateToken
{
    constructor()
    {
        super();
        document.getElementById('searchTerm').addEventListener('keyup', this.showHint);
        document.getElementById('searchTerm').addEventListener('click', this.showHistory);
        document.getElementById('clearSearch').addEventListener('click', this.clearBox);
        self.users = {};
        self.queue = new QueueDS();
        self.extendSearch = new SearchSystemExtended();
    }

    /**
     * show the history search when click on the search box
     */
    showHistory()
    {
        if(self.queue.length() !== 0) // is search history is more than zero
        {
            let uic = document.getElementById('searchSuggestion');
            uic.innerHTML = '';
            document.getElementById('searchCool').style.cssText ="background: white; padding: 5px 10px 5px 5px; margin: 60px 0px 0px; border-radius: 5px; max-width: 206px; min-width: 206px;";
            console.log("history");
            for(let i=0; i<self.queue.length(); i++) // iterate to display each search element
            {
                uic.innerHTML += '<div class="blockHov"><p class="truncateTextSearch">' + self.queue.getElement(i) + '</p></div>';
            }
            uic.innerHTML += '<div id="clearHistoryList" class="clearHistory"><a>Clear history</a></div><br/>';
            document.getElementById('clearHistoryList').addEventListener("click", function () { clearHistory(); })
        }

        /**
         * to clear the search history
         */
        function clearHistory()
        {
            self.queue.clearList();
            let uic = document.getElementById('searchSuggestion');
            document.getElementById('searchCool').style.cssText = "";
            uic.innerHTML = '';
        }
    }

    /**
     * to display the suggestions dynamically
     * @param event
     */
    showHint(event)
    {

        if (this.value.length === 0)
        {
            document.getElementById('clearSearch').style.display = "none";
            document.getElementById('searchSuggestion').innerHTML = "";
            let designSearch = document.getElementById('searchCool').style.cssText ="";
        }
        else
        {
            document.getElementById('searchTerm').style.paddingRight = "35px";
            document.getElementById('clearSearch').style.display = "inline";
            let output;
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    let uic = document.getElementById('searchSuggestion');
                    document.getElementById('searchCool').style.cssText ="background: white; padding: 5px 10px 5px 5px; margin: 60px 0px 0px; border-radius: 5px; max-width: 225px; min-width: 206px;";
                    self.users = JSON.parse(this.responseText);
                    uic.innerHTML = "";
                    let count = 0;
                    let checkURL = window.location.href.split('/').reverse()[0];
                    let total = 0;
                    self.users.forEach(function (obj)
                    {
                        if(obj.image !== null && count < 6)
                        {
                            uic.innerHTML += '<div class="blockHov" onclick="location.href=\'../Models/Core.php?user_ID_details=' + obj.user_ID + '\';"><img style="margin-right: 10px; border-radius: 50%" src="../../images/users/' +  obj.image + '" height="50px" width="50px" alt="picture"><div class="blockHov">' + " " +  obj.full_name + "</div></div><br/>";
                        }
                        else if (count < 6)
                        {
                            uic.innerHTML += '<div class="blockHov" onclick="location.href=\'../Models/Core.php?user_ID_details=' + obj.user_ID + '\';"><img style="margin-right: 10px; border-radius: 50%" src="../../images/website/images/default.png" height="50px" width="50px" alt="picture"><div class="blockHov">' + " " +  obj.full_name + "</div></div><br/>";
                        }
                        count++;
                    });
                    if (count > 6)
                    {
                        this.total = count-6;
                        output = '<a>' + this.total + " more" + '</a>';
                        console.log(this.total);
                    }
                    else
                    {
                        output = "";
                    }
                    uic.innerHTML += '<div onclick="self.extendSearch.showAllResults(self.users)" class="clearHistory">' + output + '</div><br/>';
                    document.getElementById('closeSearchFrame').addEventListener("click", self.extendSearch.hideAllResults);
                }
            };
            xmlhttp.open('GET', '../../Ajax/realTimeSearch.php?q=' + this.value + '&token=' + super.getToken(), true);
            xmlhttp.send();
        }
    }

    /**
     * to close the result box
     */
    clearBox()
    {
        let collectHistory = function ()
        {
            if (self.queue.length() <= 6)
            {
                if (self.queue.length() === 6)
                {
                    self.queue.dequeue();
                    self.queue.enqueue(document.getElementById('searchTerm').value);
                }
                else
                {
                    self.queue.enqueue( document.getElementById('searchTerm').value);
                }
            }
        }
        collectHistory();
        document.getElementById('searchTerm').style.paddingRight = "0.75rem";
        document.getElementById('searchTerm').value = "";
        document.getElementById('searchCool').style.cssText ="";
        document.getElementById('searchSuggestion').innerHTML = "";
        document.getElementById('clearSearch').style.display = "none";
        console.log("hide : " + self.queue.collection());
    }
}