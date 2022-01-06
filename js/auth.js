// Create a account if the sign up form is good
$(document).ready(function () {
    $("#sign > form").submit(function (event) {
        event.preventDefault(); // Since im handling the Ajax request on the same page an 
        // Get the field data 
        let data = { name: "", email: "", cPassword: "" }
        data.name = event.target[0].value
        data.email = emailCheck(event.target[1].value)
        data.cPassword = confirmPasswordsCheck(event.target[2].value, event.target[3].value)

        if (data.cPassword && data.email && event.target[4].value) {
            // Show the loading btn and hide the submit btn
            $("#sign > form > button").addClass("visually-hidden")
            $("#sign > form > button").last().removeClass("visually-hidden")

            // Send create account Req
            let xhr = new XMLHttpRequest();
            xhr.open("POST", 'api/createaccount.php', true);

            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                // console.log(this.status)
                if (this.readyState === XMLHttpRequest.DONE) {
                    // hide the loading btn and show the submit btn
                    $("#sign > form > button").addClass("visually-hidden")
                    $("#sign > form > button").first().removeClass("visually-hidden")
                    if (this.status === 200) {
                        // is Auth and account created
                        // console.log(this.responseText)
                        showStatusToast("Account Created, Please Login", "success")
                        $("#login-tab").click() // send user to the login form
                    } else if (this.status === 422) {
                        // Invalid data passed to the server or something went wrong- show user the error
                        console.error(this.responseText)
                        if (this.responseText.includes("Duplicate") && this.responseText.includes("email")) {
                            showStatusToast("Email is already in use, try another one.", "error")
                        } else {
                            showStatusToast(this.responseText, "error") // for more debuggin
                        }
                    }
                }
            }
            //xhr.send("json="+JSON.stringify(data)); // Send the Create account post as json but it uses urlencode
            xhr.send(JSON.stringify(data)); // Send the Create account post

        }
    })
});

/**
 * Check if this is a valid email format.
 * @param {String} email 
 */
function emailCheck(email) {
    const RE = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    let cleanedEmail = cleanInput(email)
    if (cleanedEmail.match(RE)) {
        return cleanedEmail
    } else {
        showStatusToast("Invalid email", "error")
        return false
    }
}
/**
 * check if the created password is valid (min 6 char, include a number and upper case char)
 * @param {String} passw1 
 * @param {String} passw2 
 */
function confirmPasswordsCheck(p1, p2) {
    let RE = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$/ // min 6 char, include a number and upper case char Regular expression
    let firstPassword = cleanInput(p1);
    let confirmPassword = cleanInput(p2);

    // toast pop up that the passwords dont match or contain the right character 
    if (!firstPassword.match(RE)) {
        showStatusToast("Password must contain uppercase, lowercase, numeric and be more than five characters in length", "error")
        return false;
    } else if (firstPassword != confirmPassword) {
        showStatusToast("Passwords dont match, Please check them", "error")
        return false;

    } else {
        return firstPassword
    }
}
