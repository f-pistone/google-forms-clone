$(document).ready(function () {
  //Button to open the profile box
  $("#open_profile_box_button").on("click", function () {
    const profile_box = $("#profile-box");
    if ($(profile_box).hasClass("hidden")) {
      $(profile_box).removeClass("hidden");
    } else {
      $(profile_box).addClass("hidden");
    }
  });
});
