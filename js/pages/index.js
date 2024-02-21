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
    $("#rename_form_button").prop("disabled", false);
    $("#rename_form_button").removeClass("!text-gray-400");
    $("#rename_form_button").removeClass("!bg-slate-100");
  });

  //Check new title value
  $("#new_title_form").on("keyup", function () {
    const value = $(this).val();
    if ($.trim(value) === "" || value === undefined) {
      $("#rename_form_button").prop("disabled", true);
      $("#rename_form_button").addClass("!text-gray-400");
      $("#rename_form_button").addClass("!bg-slate-100");
    } else {
      $("#rename_form_button").prop("disabled", false);
      $("#rename_form_button").removeClass("!text-gray-400");
      $("#rename_form_button").removeClass("!bg-slate-100");
    }
  });

  //Button to rename the form
  $("#rename_form_button").on("click", function () {
    const id_form = $("#id_form_to_rename").val();
    const new_title_form = $("#new_title_form").val();

    if ($.trim(new_title_form) === "" || new_title_form === undefined) {
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
          $("#close-rename-form-modal").click();
          Toastify({
            text: "Title changed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
          $(`.form[data-id-form="${id_form}"]`)
            .find(".title-form")
            .text(new_title_form);
        } else {
          $("#close-rename-form-modal").click();
          Toastify({
            text: "Error",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to open the modal to remove the form
  $("#forms_list").on("click", ".open-remove-form-modal", function () {
    const form = $(this).parents(".form");
    const id_form = $(form).attr("data-id-form");
    const title_form = $(form).find(".title-form").text();
    $("#id_form_to_remove").val(id_form);
    $("#remove_title_form").text(title_form);
    document.getElementById("remove_form_modal").showModal();
  });

  //Button to close the modal to remove the form
  $("#close-remove-form-modal").on("click", function () {
    document.getElementById("remove_form_modal").close();
    $("#id_form_to_remove").val("");
    $("#remove_title_form").text("");
  });

  //Button to remove the form
  $("#remove_form_button").on("click", function () {
    const id_form = $("#id_form_to_remove").val();

    $.ajax({
      type: "POST",
      url: "php/remove_form.php",
      data: {
        id_form: id_form,
      },
      success: function (response) {
        if (response == true) {
          $("#close-remove-form-modal").click();
          Toastify({
            text: "Form removed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
          $(`.form[data-id-form="${id_form}"]`).fadeOut(800, function () {
            $(`.form[data-id-form="${id_form}"]`).remove();
          });
        } else {
          $("#close-remove-form-modal").click();
          Toastify({
            text: "Error",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });
});
