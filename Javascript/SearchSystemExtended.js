/**
 * the class SearchSystemExtended serves to extend the search system
 */
class SearchSystemExtended
{
    constructor()
    {

    }

    /**
     * show all results on a bigger box
     * @param users
     */
    showAllResults(users)
    {
        document.getElementById('searchTerm').style.paddingRight = "0.75rem";
        document.getElementById('searchTerm').value = "";
        document.getElementById('searchCool').style.cssText ="";
        document.getElementById('searchSuggestion').innerHTML = "";
        document.getElementById('clearSearch').style.display = "none";
        document.getElementsByClassName('outer-popup-fullSearch')[0].style.display = 'flex';
        document.getElementsByClassName('containerUsers')[0].style.filter = "blur(20px)";
        document.getElementById('pagination').style.filter = "blur(20px)";
        let showAll = document.getElementById('javaScriptAdd');
        showAll.innerHTML = "";
        showAll.innerHTML += '<br/>';
        users.forEach(function (obj) // foreach loop to display each user using JSON
        {
            if(obj.image == null)
            {
                showAll.innerHTML += '<div class="blockHov" onclick="location.href=\'../Models/Core.php?user_ID_details=' + obj.user_ID + '\';"><img style="margin-right: 10px; border-radius: 50%" src="../../images/website/images/default.png" height="50px" width="50px" alt="picture"><div class="blockHov">' + " " +  obj.full_name + "</div></div><br/>";
            }
            else
            {
                showAll.innerHTML += '<div class="blockHov" onclick="location.href=\'../Models/Core.php?user_ID_details=' + obj.user_ID + '\';"><img style="margin-right: 10px; border-radius: 50%" src="../../images/users/' +  obj.image + '" height="50px" width="50px" alt="picture"><div class="blockHov">' + " " +  obj.full_name + "</div></div><br/>";
            }
        });
    }

    /**
     * close the reuslt box
     */
    hideAllResults()
    {
        console.log("hide");
        document.getElementsByClassName('outer-popup-fullSearch')[0].style.display = 'none';
        document.getElementsByClassName('containerUsers')[0].style.filter = "none";
        document.getElementById('pagination').style.filter = "none";
    }
}