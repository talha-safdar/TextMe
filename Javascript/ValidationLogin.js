/**
 * the class ValidationLogin which extends GenerateToken
 * serves to validate and login the user
 */
class ValidationLogin extends GenerateToken
{
    constructor()
    {
        super();
        this.email = document.getElementById('email');
        this.password = document.getElementById('password');
        this.errorMessageLogin = document.getElementById('errorMessageLogin');
        this.loggedInButton = document.getElementById('loggedInButton');
        this.loggedInButton.disabled = true;
        this.validateEmail();
        self.email.addEventListener("focusout", this.validateEmail);
        self.password.addEventListener("focusout", this.enableSubmitLogin);
        self.loggedInButton.addEventListener("click", this.logIn);
    }

    /**
     * to validate the email
     * @returns {boolean}
     */
    validateEmail()
    {
        if (self.email.value.length === 0 || self.email.value.match(/^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/))
        {
            console.log("1 if")
            self.email.style.borderColor = "black";
            ValidationLogin.access = true;
            if(self.email.value.length != 0 && self.password.value.length != 0)
            {
                console.log("2 if")
                self.loggedInButton.disabled = false;
            }
            return true;
        }
        else
        {
            console.log("1 else")
            ValidationLogin.access = false;
            self.loggedInButton.disabled = true;
            self.email.style.borderColor = "red";
            return true;
        }
    }

    /**
     * to login the user
     */
    logIn()
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                if (this.responseText == 0) // success
                {
                    window.location.replace("../loggedInPage.php");
                }
                if(this.responseText == 1) // password incorrect
                {
                    self.errorMessageLogin.innerHTML = '<div class="alert alert-danger text-center" >Password incorrect</div>';
                }
                if (this.responseText == 2) // email incorrect
                {
                    self.errorMessageLogin.innerHTML = '<div class="alert alert-danger text-center" >Email incorrect</div>';
                }
                if (this.responseText == 3) // email validation failed
                {
                    self.errorMessageLogin.innerHTML = '<div class="alert alert-danger text-center" >Internal error</div>';
                }
            }
        };
        xmlhttp.open('GET', '../../Ajax/logIn.php?email=' + self.email.value + "&password=" + self.password.value + '&token=' + super.getToken(), true);
        xmlhttp.send();
    }

    /**
     * to enable the "Submit" button
     */
    enableSubmitLogin()
    {
        console.log(ValidationLogin.access);
        if(self.email.value.length != 0 && self.password.value.length != 0 && ValidationLogin.access == true)
        {
            self.loggedInButton.disabled = false;
        }
        else
        {
            self.loggedInButton.disabled = true;
        }
    }
}

ValidationLogin.access = false; // variable to ensure the email is correct