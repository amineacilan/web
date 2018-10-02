var
  redCirclePath = "/images/Circle-red-32.png",
  greyCirclePath = "/images/Circle-grey-32.png",
  updateIntervalTime = 1000,
  delayTime = 5000,
  fadeInTime = 400,
  fadeOutTime = 600,
  prevActions = [],
  hlColor = '#01DFA5',
  hlInterval = 200,
  hlCounter = 0,
  timeoutCounter = 0,
  responseReceivedUiValues = true,
  timerUpdate, hlTimer, hlElem, origColor;

function highLightElement(elemId)
{
  if (hlElem != null)
  {
    $(hlElem).css("background-color", origColor);
  }

  hlElem = elemId;
  origColor = $(hlElem).css("background-color");
  clearInterval(hlTimer);
  hlTimer = setInterval('toggleHlColor()', hlInterval);
  hlCounter = 0;
}

function toggleHlColor()
{
  ++hlCounter;

  if (hlCounter == 4)
  {
    clearInterval(hlTimer);
    $(hlElem).css("background-color", origColor);
    return;
  }

  var color = $(hlElem).css("background-color");

  if (color == origColor)
  {
    $(hlElem).css("background-color", hlColor);
  }
  else
  {
    $(hlElem).css("background-color", origColor);
  }
}

function activateTab(tabIndex)
{
  $("#tabs").tabs("option", "active", tabIndex);
}

function updateUI()
{
  if ((responseReceivedUiValues == true) || (++timeoutCounter >= 10))
  {
    timeoutCounter = 0;
    responseReceivedUiValues = false;
    getUserInterfaceValues();
  }
}

function AjaxRequestFailed(result) {
}

function getUserInterfaceValues()
{
  $.ajax({
    type: 'POST',
    url: 'control/getUserInterfaceValues.php',
    data: {timestamp: $.now(), modem_id: modemId, modbus_adr: modbusAdr},
    success: function(response) {
      getUserInterfaceValues_Callback(response);
    },
    error: AjaxRequestFailed
  });
}

function createAction(actionType, paramName, writeValue, creator)
{
  console.log({actionType:actionType, paramName:paramName, writeValue:writeValue, creator:creator});
  var paramId = paramList[paramName];

  if (creator == undefined)
  {
    creator = username;
  }

  $.ajax({
    type: 'POST',
    url: 'control/createAction.php',
    data: {timestamp: $.now(), action_type: actionType, param_id: paramId, write_value: writeValue,
      username: creator, device_id: deviceId, modem_id: modemId, modbus_adr: modbusAdr},
    success: function(response) {
      console.log(response);
      createAction_Callback(response);
    },
    error: AjaxRequestFailed
  });
}

function abortAction(actionId)
{
  $.ajax({
    type: 'POST',
    url: 'control/abortAction.php',
    data: {timestamp: $.now(), id: actionId},
    success: function(response) {
      abortAction_Callback(response);
    },
    error: AjaxRequestFailed
  });
}

function abortAction_Callback(response)
{
  updateUI();
}

function createTable(headerArray, valueArray, tableId, className)
{
  var colCount = headerArray.length;
  var rowCount = valueArray.length;

  var table = $('<table class="' + className + '" id="' + tableId + '">');
  var k, tempTr, tempTd;

  tempTr = $('<tr>');

  for (k = 0; k < colCount; ++k)
  {
    tempTd = $('<th>');
    tempTd.append(headerArray[k]);
    tempTr.append(tempTd);
  }

  table.append(tempTr);

  for (k = 0; k < rowCount; ++k)
  {
    var row = valueArray[k];
    tempTr = $('<tr>');

    for (var i = 0; i < colCount; ++i)
    {
      tempTd = $('<td>');
      tempTd.append(row[i]);
      tempTr.append(tempTd);
    }

    table.append(tempTr);
  }

  return table;
}

function convertDate(dateString)
{
  if (dateString.indexOf('-') != -1)
  {
    var dtSplit = dateString.split(' ');
    var dt = $.datepicker.parseDate('yy-mm-dd', dtSplit[0]);
    var dateStr = $.datepicker.formatDate('dd.mm.yy', dt);

    return (dtSplit.length == 1) ? dateStr : (dateStr + ' ' + dtSplit[1]);
  }
  else if (dateString.indexOf('.') != -1)
  {
    var dtSplit = dateString.split(' ');
    var dt = $.datepicker.parseDate('dd.mm.yy', dtSplit[0]);
    var dateStr = $.datepicker.formatDate('yy-mm-dd', dt);

    return (dtSplit.length == 1) ? dateStr : (dateStr + ' ' + dtSplit[1]);
  }

  return dateString;
}

function contains(arr, findValue)
{
  var i = arr.length;

  while (i--)
  {
    if (arr[i] === findValue)
    {
      return true;
    }
  }

  return false;
}