/**
 * Created by dev on 03/06/2015.
 */
function checkform() {

    document.getElementById('messageError').innerHTML = "";

    var theurl = document.form.value;
    var tomatch = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/
    if (!tomatch.test(theurl)) {
        document.getElementById('form').scrollIntoView();
        document.getElementById('idurl').style.border = "2px solid red";
        document.getElementById('idlabelurl').style.color = "red";
        document.getElementById('messageError').innerHTML = "Veuillez rentrer une url correcte";
        return false;
    }
    else {
        document.getElementById('idurl').style.border = "2px solid grey";
        document.getElementById('idlabelurl').style.color = "#5A5A5A";
    }

    return true;

}