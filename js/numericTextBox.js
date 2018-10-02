
function numericTextBox(e) {
    var keynum;
    if (window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if (e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }
    if (!(keynum == 9 || keynum == 8 || keynum == 45 || keynum == 48 || keynum == 49 || keynum == 50
            || keynum == 51 || keynum == 52 || keynum == 53 || keynum == 54
            || keynum == 55 || keynum == 56 || keynum == 57)) {
        return false;
    }
}

function numericTextBoxPercent(e) {
    var keynum;
    if (window.event) // IE
    {
        keynum = e.keyCode;
    }
    else if (e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which;
    }
    if (!(keynum == 9 || keynum == 8 || keynum == 44 || keynum == 46 || keynum == 45 || keynum == 48 || keynum == 49 || keynum == 50
            || keynum == 51 || keynum == 52 || keynum == 53 || keynum == 54
            || keynum == 55 || keynum == 56 || keynum == 57)) {
        return false;
    }
}

