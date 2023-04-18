/**
 * class Loading serves to dynamically show loading page
 */
class Loading
{
    constructor()
    {
        if(document.querySelector('header') != null)
        {
            document.querySelector('header').style.visibility = 'hidden'; // hide header
            this.load();
        }
        else
        {
            document.getElementById("loading").style.display = "none"; // hide loading
        }
    }

    /**
     * to hide the loading page when the pade is loaded
     */
    load()
    {
        window.onload = function()
        {
            document.querySelector('header').style.visibility = "visible"; // show loading
            document.getElementById("loading").style.display = "none"; // hide loading
        }
    }
}