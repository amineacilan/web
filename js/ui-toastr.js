var UIToastr = function() {
  return {
    //main function to initiate the module
  init: function() {
//    var i = -1,
////    toastCount = 0,
//    $toastlast,
//    getMessage = function() {
//      var msgs = ['Hello, some notification sample goes here',
//        '<div><input class="form-control input-small" value="textbox"/>&nbsp;<a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank">Check this out</a></div><div><button type="button" id="okBtn" class="btn blue">Close me</button><button type="button" id="surpriseBtn" class="btn default" style="margin: 0 8px 0 8px">Surprise me</button></div>',
//        'Did you like this one ? :)',
//        'Totally Awesome!!!',
//        'Yeah, this is the Metronic!',
//        'Explore the power of Metronic. Purchase it now!'
//      ];
//      i++;
//      if (i === msgs.length) {
//        i = 0;
//      }
//
//      return msgs[i];
//    };
    if (showDuration !== '') {
      toastr.options.showDuration = showDuration;
    }
    if (hideDuration !== '') {
      toastr.options.hideDuration = hideDuration;
    }
    if (timeOut !== '') {
      toastr.options.timeOut = timeOut;
    }
    if (extendedTimeOut !== '') {
      toastr.options.extendedTimeOut = extendedTimeOut;
    }
    if (showEasing !== '') {
      toastr.options.showEasing = showEasing;
    }
    if (hideEasing !== '') {
      toastr.options.hideEasing = hideEasing;
    }
    if (showMethod !== '') {
      toastr.options.showMethod = showMethod;
    }
    if (hideMethod !== '') {
      toastr.options.hideMethod = hideMethod;
    }
    if (!msg) {
      msg = getMessage();
    }
    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
}
};
}();