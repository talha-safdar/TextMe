/**
 * the class ValidationRegister which extends GenerateToken
 * server to validate and register the user
 */
class ValidationRegister extends GenerateToken
{
    constructor()
    {
        super();
        this.errorMessageRegister = document.getElementById('errorMessageRegister');
        this.email = document.getElementById('email');
        this.emailL = document.getElementById('emailL');
        this.name = document.getElementById('name');
        this.nameL = document.getElementById('nameL');
        this.username = document.getElementById('username');
        this.usernameL = document.getElementById('usernameL');
        this.password = document.getElementById('password');
        this.passwordL = document.getElementById('passwordL');
        this.passwordRepeat = document.getElementById('passwordRepeat');
        this.humanVerification = document.getElementById('humanVerification');
        this.bot = document.getElementById('bot');
        this.submitButton = document.getElementById('registeredButton');
        this.submitButton.disabled = true;
        this.submitButton.addEventListener("click", this.register);
        document.getElementById('email').addEventListener("focusout", this.validateEmail);
        document.getElementById('name').addEventListener("focusout", this.validateFullName);
        document.getElementById('username').addEventListener("focusout", this.validateUsername);
        document.getElementById('password').addEventListener("focusout", this.validatePassword);
        document.getElementById('passwordRepeat').addEventListener("focusout", this.validatePasswordRepeat);
        document.getElementById('humanVerification').addEventListener("focusout", this.validateHumanVerification);
    }

    /**
     * to validate the email
     * @returns {boolean}
     */
    validateEmail()
    {
        if (self.email.value.length === 0 || self.email.value.match(/^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+.([A-Za-z]{2,4})$/))
        {
            if(self.email.value.length > 0)
            {
                ValidationRegister.emailA = true;
            }
            else
            {
                ValidationRegister.emailA = false;
            }
            self.errorMessageRegister.innerHTML = '';
            self.email.style.borderColor = "black";
            ValidationRegister.enableSubmit();
            return true;
        }
        else
        {
            ValidationRegister.emailA = false;
            self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Wrong email format</div>';
            self.email.style.borderColor = "red";
            return true;
        }
    }

    /**
     * to validate the full name
     * @returns {boolean}
     */
    validateFullName()
    {
        if (document.getElementById('name').value.length === 0 || !document.getElementById('name').value.match(/[\d]+/))
        {
            if(document.getElementById('name').value.length > 0)
            {
                ValidationRegister.nameA = true;
            }
            else
            {
                ValidationRegister.nameA = false;
            }
            self.errorMessageRegister.innerHTML = '';
            document.getElementById('name').style.borderColor = "black";
            ValidationRegister.enableSubmit();
            return true;
        }
        else
        {
            ValidationRegister.nameA = false;
            self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Wrong full name format</div>';
            self.name.style.borderColor = "red";
            return true;
        }
    }

    /**
     * to validate the username
     * @returns {boolean}
     */
    validateUsername()
    {
        if (document.getElementById('username').value.length === 0 || (document.getElementById('username').value.match(/^[A-Za-z0-9]*$/) && !document.getElementById('username').value.match(/^\d/)))
        {
            if(document.getElementById('username').value.length > 0)
            {
                ValidationRegister.usernameA = true;
            }
            else
            {
                ValidationRegister.usernameA = false;
            }
            self.errorMessageRegister.innerHTML = '';
            self.username.style.borderColor = "black";
            ValidationRegister.enableSubmit();
            return true;
        }
        else
        {
            ValidationRegister.usernameA = false;
            self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Wrong username format</div>';
            self.username.style.borderColor = "red";
            return true;
        }
    }

    /**
     * to validate the password
     * @returns {boolean}
     */
    validatePassword()
    {
        if (document.getElementById('password').value.length == 0 || document.getElementById('password').value.length >= 6)
        {
            if(document.getElementById('password').value.length > 0)
            {
                if (ValidationRegister.passwordRepeatA == true)
                {
                    ValidationRegister.passwordA = document.getElementById('passwordRepeat').value === document.getElementById("password").value;
                }
                else
                {
                    ValidationRegister.passwordA = true;
                }
            }
            else
            {
                ValidationRegister.passwordA = false;
            }
            self.errorMessageRegister.innerHTML = '';
            self.password.style.borderColor = "black";
            ValidationRegister.enableSubmit();
            return true;
        }
        else
        {
            ValidationRegister.passwordA = false;
            document.getElementById('registeredButton').disabled = true;
            let missing = 6-parseInt(document.getElementById('password').value.length);
            self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Type ' + missing + ' more characters</div>';
            self.password.style.borderColor = "red";
            return true;
        }
    }

    /**
     * to validate the matching confirm password
     * @returns {boolean}
     */
    validatePasswordRepeat()
    {
        if (document.getElementById('passwordRepeat').value === document.getElementById("password").value)
        {
            ValidationRegister.passwordRepeatA = true;
            self.errorMessageRegister.innerHTML = '';
            self.password.style.borderColor = "black";
            self.passwordRepeat.style.borderColor = "black";
            ValidationRegister.enableSubmit();
            return true;
        }
        else
        {
            ValidationRegister.passwordRepeatA = false;
            self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Passwords do not match</div>';
            self.password.style.borderColor = "red";
            self.passwordRepeat.style.borderColor = "red";
            return true;
        }
    }

    /**
     * validate human verification
     */
    validateHumanVerification()
    {

        if (document.getElementById('humanVerification').value.length == 0 || document.getElementById('humanVerification').value.length > 0)
        {
            ValidationRegister.enableSubmit();
        }
    }

    /**
     * register user
     */
    register()
    {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function ()
        {
            if (this.readyState === 4 && this.status === 200)
            {
                console.log(this.responseText);
                if(this.responseText == 0) // success
                {
                    window.location.replace("../index.php");
                }
                else if(this.responseText == 1) // one field missing
                {
                    self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >one field is missing</div>';
                }
                else if(this.responseText == 6) // one field missing
                {
                    self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Passwords do not match</div>';
                }
                else if(this.responseText == 7) // email already taken
                {
                    self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Email already taken</div>';
                }
                else if(this.responseText == 8) // email already taken
                {
                    self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Username already taken</div>';
                }
                else if(this.responseText == 9) // human verification failed
                {
                    self.errorMessageRegister.innerHTML = '<div class="alert alert-danger text-center" >Human verification failed</div>';
                }
            }
        };
        xmlhttp.open('GET', '../../Ajax/register.php?email=' + document.getElementById('email').value + "&fullName=" + document.getElementById('name').value + '&username=' + document.getElementById('username').value + '&password=' + document.getElementById('password').value + '&passwordRepeat=' + document.getElementById('passwordRepeat').value + '&verification=' + document.getElementById('humanVerification').value + '&bot=' + document.getElementById('bot').value + '&token=' + super.getToken(), true);
        xmlhttp.send();
    }
}

/**
 * to enable the "Submit" button if all fileds are validated
 */
ValidationRegister.enableSubmit = function ()
{
    console.log(ValidationRegister.access);
    if(self.email.value.length != 0 && document.getElementById('name').value.length != 0 && self.password.value.length != 0 && self.passwordRepeat.value.length != 0 && self.humanVerification.value.length != 0)
    {
        if(ValidationRegister.emailA == true && ValidationRegister.nameA == true && ValidationRegister.usernameA == true && ValidationRegister.passwordA == true && ValidationRegister.passwordRepeatA == true)
        {
            document.getElementById('registeredButton').disabled = false;
        }
    }
    else
    {
        document.getElementById('registeredButton').disabled = true;
    }
}

ValidationRegister.emailA = false; // ensure email is in correct format
ValidationRegister.nameA = false; // ensure name is correct format
ValidationRegister.usernameA = false; // ensure username is in correct format
ValidationRegister.passwordA = false; // ensure password is in correct format
ValidationRegister.passwordRepeatA = false; // ensure password matches