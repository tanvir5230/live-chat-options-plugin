jQuery(document).ready(function ($) {
  // open live chat panel when live chat button is clicked
  $("#live-chat-open-button").click(function () {
    $("#live-chat-panel").show();
  });

  // close live chat panel when cross button is clicked
  $("#live-chat-close-button").click(function () {
    $("#live-chat-panel").hide();
  });
});
