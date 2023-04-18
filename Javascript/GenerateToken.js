/**
 * class GenerateToken serves to generate tokens
 */
class GenerateToken
{
    constructor()
    {
        this.generateToken(); // call class function
    }

    /**
     * to generate the token
     */
    generateToken()
    {
        let xmlhttp = new XMLHttpRequest(); // instantiate XMLHttpRequest
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                self.token = this.responseText; // assign token to variable
            }
        };
        xmlhttp.open('POST', '../../Ajax/generateToken.php', true);
        xmlhttp.send();
    }

    /**
     * getter to get the token
     * @returns {*}
     */
    getToken()
    {
        return self.token;
    }
}