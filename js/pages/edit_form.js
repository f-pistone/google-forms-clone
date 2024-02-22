$(document).ready(function () {
  document.title = $("#header_title_form").val();

  //Button to open the options menu of the form
  $(".open-options-menu").on("click", function () {
    const options_menu_to_open = $(this).next(".options-menu");
    if ($(options_menu_to_open).hasClass("hidden")) {
      $(options_menu_to_open).removeClass("hidden");
    } else {
      $(options_menu_to_open).addClass("hidden");
    }
  });

  //Toggle the active class for the form boxes
  $(".form-box").on("click", function () {
    $(".form-box").removeClass("active-form-box");
    $(this).addClass("active-form-box");
  });
});
