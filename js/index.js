$(document).ready(
    function () {
        // Show the cookie pop up after 3 seconds of using the site
        var cookieToastEl = $("#cookieToast")
        setTimeout(function () {
            var cookieToastShown = localStorage.getItem("cookieToastShown");
            if (cookieToastShown == "false" || !cookieToastShown) {
                var toast = new bootstrap.Toast(cookieToastEl)
                toast.show()
                localStorage.setItem("cookieToastShown", true)
            }
        }, 3000)
    })

/**
 * i used Jquery and DOM manipulation to  achieve this pop up effect for most of the user feedback
 * @param {*} msg message in the toast pop up
 * @param {*} status colour code of the pop up
 */
function showStatusToast(msg, status) {
    let statusToastEl = $("#statusToast")
    statusToastHeaderEl = statusToastEl.find("div.toast-header strong")
    statusToastEl.removeClass("bg-danger bg-success bg-black")
    switch (status) {
        case 'error':
            statusToastEl.addClass("bg-danger text-white")
            statusToastHeaderEl.text("Error")
            break;
        case 'success':
            statusToastEl.addClass("bg-success text-white")
            statusToastHeaderEl.text("Success")
            break;
        default:
            statusToastEl.addClass("text-white bg-black")
            statusToastHeaderEl.text("Status")

    }
    let statustoast = new bootstrap.Toast(statusToastEl)
    statusToastEl.find("div.toast-body p").text(msg)
    statustoast.show()
}
function cleanInput(string) {
    return string.trim()
}