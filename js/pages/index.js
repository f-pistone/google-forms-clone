$(document).ready(function () {
  //Button for opening the options menu of the form
  $("#forms_list").on("click", ".open-options-menu", function () {
    const options_menu_to_open = $(this).next(".options-menu");
    if ($(options_menu_to_open).hasClass("hidden")) {
      $(options_menu_to_open).removeClass("hidden");
    } else {
      $(options_menu_to_open).addClass("hidden");
    }
  });

  //Button for opening the modal to rename the form
  $("#forms_list").on("click", ".open-rename-form-modal", function () {
    const title_form = $("#title_form").text();
    $("#new_title_form").val(title_form);
    document.getElementById("rename_form_modal").showModal();
  });

  //Button for closing the modal to rename the form
  $("#close-rename-form-modal").on("click", function () {
    document.getElementById("rename_form_modal").close();
    $("#new_title_form").val("");
  });
});
