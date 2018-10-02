// XML Worker
var xdo;
var xmlDoc;
var objHTTP;
// Countdown
var sec = 00;
var min = 05;
var SD;
var Timer;
// public Variable
var returnValue;
var _value;
var _productId;
var _successURL;
var _cancelURL;
var _merchantPostURL;
var strResult;

var classP = "process-p";
var classA = "process-a";
var classE = "process-e";

function setTimer(value, productId, successURL, cancelURL, merchantPostURL) {

    _value = value;
    _productId = productId;
    _successURL = successURL;
    _cancelURL = cancelURL;
    _merchantPostURL = merchantPostURL;

    document.getElementById("_x6").style.display = 'none';

    checkStatus(value);

    if (returnValue == "0") // Yeni İŞlem
    {
        document.getElementById("_x3").className = classP;
        document.getElementById("_x4").className = classP;
        document.getElementById("_x5").className = classP;

        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
    else if (returnValue == "1") // Confrim mesajı gönderilemedi
    {
        document.getElementById("_x3").className = classE;

        alert("Satınalma onay mesajı gönderilemedi; \n- Cep telefonunuzun açık ve şebekeye bağlı olduğundan emin olunuz.");
        window.setTimeout("window.close();", 2000);
        window.clearTimeout(SD);
        window.clearTimeout(Timer);

        if (window.opener != null) {
            window.opener.location.href = cancelURL;
        }
        else {
            window.location.href = cancelURL;
        }
    }
    else if (returnValue == "2" || returnValue == "1005") // Confrm Mesajı gönderildi Beklemede
    {
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;

        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
    else if (returnValue == "3") // İptal veya Timeout
    {

        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;
        document.getElementById("_x5").style.display = 'none';
        document.getElementById("_x6").style.display = 'block';
        document.getElementById("_x6").className = classE;

        if (sec == "00" && min == "00") {
            alert("Ödeme işleminiz başarısız;\nSize ayrılan 5 dakikalık süre içerisinde onay mesajına dönüş  yapmadınız. İşleminiz otomatik olarak İPTAL edilmiştir!");
        }
        if (min == "01") {
            alert("Ödeme işleminiz başarısız;\nSize ayrılan 5 dakikalık süre içerisinde onay mesajına dönüş  yapmadınız. İşleminiz otomatik olarak İPTAL edilmiştir!");
        }
        else {
            alert("Ödeme işleminiz başarısız;\nSatın alma işleminiz iptal edilmiştir.");
        }
        window.setTimeout("window.close();", 2000);
        window.clearTimeout(SD);
        window.clearTimeout(Timer);

        if (window.opener != null) {
            window.opener.location.href = cancelURL;
        }
        else {
            window.location.href = cancelURL;
        }
    }
    else if (returnValue == "4" || returnValue == "1006") // Charging Waiting
    {
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;

        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
    else if (returnValue == "5") // Charging Hata
    {
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;
        document.getElementById("_x5").style.display = 'none';
        document.getElementById("_x6").style.display = 'block';
        document.getElementById("_x6").className = classE;


        alert("Ödeme işleminiz başarısız;\n - Yeterli krediniz olduğundan yada fatura borcunuzun olmadığından emin olunuz.");
        window.setTimeout("window.close();", 2000);
        window.clearTimeout(SD);
        window.clearTimeout(Timer);

        if (window.opener != null) {
            window.opener.location.href = cancelURL;
        }
        else {
            window.location.href = cancelURL;
        }
    }
    else if (returnValue == "6") { // Charging OK, Product Wait
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;

        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
    else if (returnValue == "7") { // Merchanttan kod alınamadı.
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;
        document.getElementById("_x5").style.display = 'none';
        document.getElementById("_x6").style.display = 'block';
        document.getElementById("_x6").className = classE;

        alert("Satın alma işlemi esnasında üye iş yerine bilgilerin aktarılmasında bir problem oluştu. Satın alma işleminiz tamamlandığında SMS ile size bilgi verilecektir.");
        window.setTimeout("window.close();", 2000);
        window.clearTimeout(SD);
        window.clearTimeout(Timer);


        if (window.opener != null) {
            window.opener.location.href = cancelURL;
        }
        else {
            window.location.href = cancelURL;
        }
    }
    else if (returnValue == "8") {
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;

        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
    else if (returnValue == "9") { // SMS Gönderiminde problem, Telefon kapalı, mesaj kutusu dolu
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;
        document.getElementById("_x5").className = classA;

        // Onay Penceresine yönlendir.

        window.clearTimeout(SD);
        alert("Ödeme işleminiz tamamlanmıştır. Üye iş yeri sayfasına yönlendiriliyorsunuz.");
        if (window.opener != null) {
            var charIndex = successURL.indexOf("?");
            if (charIndex != -1) {
                window.opener.location.href = successURL + "&x=" + _value;
            }
            else {
                window.opener.location.href = successURL + "?x=" + _value;
            }
            window.setTimeout("window.close();", 2000);
        }
        else {
            var charIndex = successURL.indexOf("?");
            if (charIndex != -1) {
                window.location.href = successURL + "&x=" + _value;
            }
            else {
                window.location.href = successURL + "?x=" + _value;
            }
            window.setTimeout("window.close();", 2000);
        }
    }
    else if (returnValue == "10") // Product Gönderildi
    {
        document.getElementById("_x3").className = classA;
        document.getElementById("_x4").className = classA;
        document.getElementById("_x5").className = classA;

        // Onay Penceresine yönlendir.

        window.clearTimeout(SD);
        alert("Ödeme işleminiz tamamlanmıştır. Üye iş yeri sayfasına yönlendiriliyorsunuz.");
        if (window.opener != null) {
            var charIndex = successURL.indexOf("?");
            if (charIndex != -1) {
                window.opener.location.href = successURL + "&x=" + _value;
            }
            else {
                window.opener.location.href = successURL + "?x=" + _value;
            }
            window.setTimeout("window.close();", 2000);
        }
        else {
            var charIndex = successURL.indexOf("?");
            if (charIndex != -1) {
                window.location.href = successURL + "&x=" + _value;
            }
            else {
                window.location.href = successURL + "?x=" + _value;
            }
            window.setTimeout("window.close();", 2000);

        }
    }
    else {
        Timer = setTimeout("setTimer('" + value + "','" + productId + "','" + successURL + "','" + cancelURL + "','" + merchantPostURL + "')", 5000);
    }
}
// Durum kontrol =)
function checkStatus(value) {    
    if (typeof window.ActiveXObject != 'undefined') {
        xmlDoc = new ActiveXObject("Microsoft.XMLHTTP");
        xmlDoc.onreadystatechange = process;
    }
    else {
        xmlDoc = new XMLHttpRequest();
        xmlDoc.onload = process;
        
    }
    xmlDoc.open("GET", "xml.aspx?date=" + new Date() + "&Value=" + value, false);
    xmlDoc.send(null);
}

function process() {
    if (xmlDoc.readyState != 4) {

        return;
    }

    try {
        returnValue = xmlDoc.responseText;
    }
    catch (err) {
        alert(err)
    }
}


// Geri sayaç
function countDown() {
    try {
        sec--;
        if (sec == -01) {
            sec = 59;
            min = min - 1;
        } else {
            min = min;
        }
        if (sec <= 9) { sec = "0" + sec; }
        time = (min <= 9 ? "0" + min : min) + ":" + sec + "  ";
        if (document.getElementById) { document.getElementById("theTime").innerHTML = time; }
        else {
            document.getElementById("theTime").innerHTML = time;
        }
        SD = window.setTimeout("countDown();", 1000);
        if (min == '00' && sec == '00') {

            document.getElementById("_x3").className = classA;
            document.getElementById("_x4").className = classA;
            document.getElementById("_x5").style.display = 'none';
            document.getElementById("_x6").style.display = 'block';
            document.getElementById("_x6").className = classE;


            alert("Ödeme işleminiz başarısız;\nSize ayrılan 5 dakikalık süre içerisinde onay mesajına dönüş  yapmadınız. İşleminiz otomatik olarak İPTAL edilmiştir!");
            
            window.setTimeout("window.close();", 2000);
            window.clearTimeout(SD);
            window.clearTimeout(Timer);

            if (window.opener != null) {
                window.opener.location.href = cancelURL;
            }
            else {
                window.location.href = cancelURL;
            }
            
            setRequestFail();
        }
    }
    catch (err) { }
}

function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        }
    }
}

addLoadEvent(function() {
    countDown();
});

// Ödeme Başarısız olarak tanımla
function setRequestFail() {
    
    if (typeof window.ActiveXObject != 'undefined') {
        xmlDoc = new ActiveXObject("Microsoft.XMLHTTP");
        xmlDoc.onreadystatechange = process;
    }
    else {
        xmlDoc = new XMLHttpRequest();
        xmlDoc.onload = process;

    }
    xmlDoc.open("Get", "xml.aspx?&work=cancel&date=" + new Date() + "&Value=" + _value, false);
    xmlDoc.send(null);
}

function XmlHttpPostData() {
    if (strResult == null || strResult == "" || strResult == undefined) {
        

        if (typeof window.ActiveXObject != 'undefined') {
            objHTTP = new ActiveXObject("Microsoft.XMLHTTP");
            objHTTP.onreadystatechange = process2;
        }
        else {
            objHTTP = new XMLHttpRequest();
            objHTTP.onload = process2;
        }

        objHTTP.open("GET", "xml.aspx?&work=setProductCode&date=" + new Date() + "&Value=" + _value + "&code=" + _productId, false);
        objHTTP.send(null);
        
        return strResult;
    }
}

function process2() {
    if (objHTTP.readyState != 4) {
        return;
    }

    try {
        strResult = objHTTP.responseText;
        return strResult;
    }
    catch (err) {
        alert(err)
    }
}
