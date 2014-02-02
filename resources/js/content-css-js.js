function iframeAutoFit() {
  var currentWindow = window;
  var parentWindow = parent;
  var isContinue = false;
  while (currentWindow != parentWindow) {
    $('iframe.autoheight', parentWindow.document).each(function() {
      if (this.contentWindow == currentWindow) {
        this.height = $(currentWindow.document).height();
        isContinue = true;
      }
    });
    if (!isContinue)
      break;
    currentWindow = parentWindow;
    parentWindow = parentWindow.parent;
  }
  ;
}

$(document).ready(function() {
  $(window).bind('load', function() {
    iframeAutoFit();
  });
});
