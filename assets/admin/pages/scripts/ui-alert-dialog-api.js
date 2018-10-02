var UIAlertDialogApi = function() {

  var handleDialogs = function() {

    $('#demo_1').click(function() {
      bootbox.alert("Hello world!");
    });
    //end #demo_1

    $('#demo_2').click(function() {
      bootbox.alert("Hello world!", function() {
        alert("Hello world callback");
      });
    });
    //end #demo_2

    $('#demo_3').click(function() {
      bootbox.confirm("Are you sure?", function(result) {
        alert("Confirm result: " + result);
      });
    });
    //end #demo_3

    $('#demo_4').click(function() {
      bootbox.prompt("What is your name?", function(result) {
        if (result === null) {
          alert("Prompt dismissed");
        } else {
          alert("Hi <b>" + result + "</b>");
        }
      });
    });
    //end #demo_6

    $('#demo_5').click(function() {
      bootbox.dialog({
        message: "I am a custom dialog",
        title: "Custom title",
        buttons: {
          success: {
            label: "Success!",
            className: "green",
            callback: function() {
              alert("great success");
            }
          },
          danger: {
            label: "Danger!",
            className: "red",
            callback: function() {
              alert("uh oh, look out!");
            }
          },
          main: {
            label: "Click ME!",
            className: "blue",
            callback: function() {
              alert("Primary button");
            }
          }
        }
      });
    });
    //end #demo_7
  };

  var handleAlerts = function() {

    $('#alert_show').click(function() {

      Metronic.alert({
        container: '#portlet', // alerts parent container(by default placed after the page breadcrumbs)
        place: 'prepend', // append or prepent in container 
        type: 'info', // alert's type
        message: '<div class="Table"><div class="Heading"><div class="Cell"><p>Marka</p></div><div class="Cell"><p>Firma</p></div><div class="Cell"><p>Flag Kodu</p></div></div><div class="Row"><div class="Cell"><p>Row 1 Column 1</p></div><div class="Cell"><p>Row 1 Column 2</p></div><div class="Cell"><p>Row 1 Column 3</p></div></div><div class="Row"><div class="Cell"><p>Row 2 Column 1</p></div><div class="Cell"><p>Row 2 Column 2</p></div><div class="Cell"><p>Row 2 Column 3</p></div></div></div>', // alert's message
        close: 1, // make alert closable
        reset: 1, // close all previouse alerts first
        focus: $('#alert_focus').is(":checked"), // auto scroll to the alert after shown
        closeInSeconds: 10 // auto close after defined seconds
                //icon: $('#alert_icon').val() // put icon before the message
      });
    });
  };

  return {
    //main function to initiate the module
    init: function() {
      handleDialogs();
      handleAlerts();
    }
  };

}();