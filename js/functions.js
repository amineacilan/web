function emailCheck(emailStr)
{
  var checkTLD = 0;
  var knownDomsPat = /^(com|tr|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
  var emailPat = /^(.+)@(.+)$/;
  var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
  var validChars = "\[^\\s" + specialChars + "\]";
  var quotedUser = "(\"[^\"]*\")";
  var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
  var atom = validChars + '+';
  var word = "(" + atom + "|" + quotedUser + ")";
  var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
  var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
  var matchArray = emailStr.match(emailPat);

  if (matchArray == null)
  {
    return false;
  }

  var user = matchArray[1];
  var domain = matchArray[2];

  for (i = 0; i < user.length; i++)
  {
    if (user.charCodeAt(i) > 127)
    {
      return false;
    }
  }

  for (i = 0; i < domain.length; i++)
  {
    if (domain.charCodeAt(i) > 127)
    {
      return false;
    }
  }

  if (user.match(userPat) == null)
  {
    return false;
  }

  var IPArray = domain.match(ipDomainPat);

  if (IPArray != null)
  {
    for (var i = 1; i <= 4; i++)
    {
      if (IPArray[i] > 255)
      {
        return false;
      }
    }

    return true;
  }

  var atomPat = new RegExp("^" + atom + "$");
  var domArr = domain.split(".");
  var len = domArr.length;

  for (i = 0; i < len; i++)
  {
    if (domArr[i].search(atomPat) == -1)
    {
      return false;
    }
  }

  if (checkTLD && domArr[domArr.length - 1].length != 2 && domArr[domArr.length - 1].search(knownDomsPat) == -1)
  {
    return false;
  }

  if (len < 2)
  {
    return false;
  }

  return true;
}

function parseDbDate(dbDate)
{
  if ((dbDate == "") || (dbDate == null))
  {
    return "";
  }

  var dateTimeSplit = dbDate.split(' ');
  var datePart = dateTimeSplit[0];
  var timePart = dateTimeSplit[1];

  var datePartValues = datePart.split('-');
  var timePartValues = timePart.split(':');

  var year = datePartValues[0],
          month = (parseInt(datePartValues[1], 10) - 1),
          day = datePartValues[2];
  var hour = timePartValues[0],
          min = timePartValues[1];

  var sec = 0;

  if (timePartValues.length > 2)
  {
    sec = timePartValues[2];
  }

  var parsedDate = new Date(year, month, day, hour, min, sec);

  if (month >= 0)
  {
    return parsedDate;
  }
  else
  {
    return "";
  }
}

function friendlyDate(date)
{
  if (isValidDate(date) == false)
  {
    return "";
  }

  var formattedValue;
  var now = new Date();

  if (date.getFullYear() != now.getFullYear())
  {
    formattedValue = $.datepicker.formatDate('MM yy', date);
  }
  else if (date.getMonth() != now.getMonth() || date.getDate() != now.getDate())
  {
    formattedValue = $.datepicker.formatDate('d MM', date);
  }
  else
  {
    formattedValue = pad(date.getHours()) + ':' + pad(date.getMinutes()) + ':' + pad(date.getSeconds());
  }

  return formattedValue;
}

function isValidDate(d)
{
  if (Object.prototype.toString.call(d) !== "[object Date]")
  {
    return false;
  }

  return !isNaN(d.getTime());
}

var pad = function(val, len)
{
  val = String(val);
  len = len || 2;
  while (val.length < len)
    val = "0" + val;
  return val;
};

function getKey(e)
{
  return e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
}

String.prototype.turkishToUpper = function() {
  var a = {"i": "İ", "ı": "I", "ş": "Ş", "ğ": "Ğ", "ü": "Ü", "ö": "Ö", "ç": "Ç"};
  return this.replace(/[iışğüçö]/g, function(b) {
    return a[b]
  }).toUpperCase();
}

String.prototype.turkishToLower = function() {
  var a = {"İ": "i", "I": "ı", "Ş": "ş", "Ğ": "ğ", "Ü": "ü", "Ö": "ö", "Ç": "ç"};
  return this.replace(/[İIŞĞÜÇÖ]/g, function(b) {
    return a[b]
  }).toLowerCase();
}

function logSafe(msg)
{
  try
  {
    if (typeof (console) != 'undefined')
    {
      console.log(msg);
    }
  }
  catch (err)
  {
  }
}

function jsNumberFormat(value, i)
{
	return value.toFixed(i).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}

// console tanımlı olmayan tarayıcılar için
if (!window.console)
{
  console = {log: function() {
    }};
}