/**
 * class LoginSystem serves to display and hide the login form
 */
class LoginSystem
{
    constructor()
    {
        document.getElementById('login').addEventListener("click", this.openLogin);
        document.getElementById('closeLogin').addEventListener("click", this.closeLogin);
    }

    /**
     * display the login form
     */
    openLogin()
    {
        document.querySelector('.outer-popup-login').style.display = "flex";
        document.getElementById('mainTable').style.filter = "blur(20px)";
        document.getElementById('pagination').style.filter = "blur(20px)";
    }

    /**
     * hide the login form
     */
    closeLogin()
    {
        document.querySelector('.outer-popup-login').style.display = "none";
        document.getElementById('mainTable').style.filter = "blur(0)";
    }
}