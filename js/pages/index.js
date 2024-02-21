$(document).ready(function () {
  //Button to open the options menu of the form
  $("#forms_list").on("click", ".open-options-menu", function () {
    const options_menu_to_open = $(this).next(".options-menu");
    if ($(options_menu_to_open).hasClass("hidden")) {
      $(options_menu_to_open).removeClass("hidden");
    } else {
      $(options_menu_to_open).addClass("hidden");
    }
  });

  //Button to open the modal to rename the form
  $("#forms_list").on("click", ".open-rename-form-modal", function () {
    const form = $(this).parents(".form");
    const id_form = $(form).attr("data-id-form");
    const title_form = $(form).find(".title-form").text();
    $("#id_form_to_rename").val(id_form);
    $("#new_title_form").val(title_form);
    document.getElementById("rename_form_modal").showModal();
  });

  //Button to close the modal to rename the form
  $("#close-rename-form-modal").on("click", function () {
    document.getElementById("rename_form_modal").close();
    $("#id_form_to_rename").val("");
    $("#new_title_form").val("");
  });

  //
  $("#rename_form_button").on("click", function () {
    const id_form = $("#id_form_to_rename").val();
    const new_title_form = $("#new_title_form").val();

    if ($.trim(new_title_form) === "" || new_title_form === undefined) {
      console.log("Insert a valid title");
      return;
    }

    $.ajax({
      type: "POST",
      url: "php/rename_form.php",
      data: {
        id_form: id_form,
        new_title_form: new_title_form,
      },
      success: function (response) {
        if (response == true) {
          console.log("Success");
          $(`.form[data-id-form="${id_form}"]`)
            .find(".title-form")
            .text(new_title_form);
          $("#close-rename-form-modal").click();
        } else {
          console.log("Error");
        }
      },
    });
  });

  //Button to open the modal to remove the form
  $("#forms_list").on("click", ".open-remove-form-modal", function () {
    const title_form = $(".title-form").text();
    $("#remove_title_form").text(title_form);
    document.getElementById("remove_form_modal").showModal();
  });

  //Button to close the modal to remove the form
  $("#close-remove-form-modal").on("click", function () {
    document.getElementById("remove_form_modal").close();
    $("#remove_title_form").text("");
  });
});
