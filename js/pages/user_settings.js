$(document).ready(function () {
  //Close the profile box
  $(document).on("click", function () {
    $("#profile-box").addClass("hidden");
  });

  //Button to open the profile box
  $("#open_profile_box_button").on("click", function (e) {
    e.stopPropagation();
    const profile_box = $("#profile-box");
    if ($(profile_box).hasClass("hidden")) {
      $(profile_box).removeClass("hidden");
    } else {
      $(profile_box).addClass("hidden");
    }
  });

  //Button to open the modal to change the name of the user
  $("#open_change_name_user_modal").on("click", function () {
    document.getElementById("change_name_user_modal").showModal();
  });

  //Button to close the modal to change the name of the user
  $("#close_change_name_user_modal").on("click", function () {
    document.getElementById("change_name_user_modal").close();
    $("#new_first_name_user").val(
      $("#new_first_name_user").attr("data-old-value")
    );
    $("#new_last_name_user").val(
      $("#new_last_name_user").attr("data-old-value")
    );
    $("#change_name_user_button").prop("disabled", false);
    $("#change_name_user_button").removeClass("!text-gray-400");
    $("#change_name_user_button").removeClass("!bg-slate-100");
  });

  //Check of the first and last name of the user values
  $("#new_first_name_user, #new_last_name_user").on("keyup", function () {
    const new_first_name_user = $("#new_first_name_user").val();
    const new_last_name_user = $("#new_last_name_user").val();
    if (
      $.trim(new_first_name_user) === "" ||
      new_first_name_user === undefined ||
      $.trim(new_last_name_user) === "" ||
      new_last_name_user === undefined
    ) {
      $("#change_name_user_button").prop("disabled", true);
      $("#change_name_user_button").addClass("!text-gray-400");
      $("#change_name_user_button").addClass("!bg-slate-100");
    } else {
      $("#change_name_user_button").prop("disabled", false);
      $("#change_name_user_button").removeClass("!text-gray-400");
      $("#change_name_user_button").removeClass("!bg-slate-100");
    }
  });

  //Button to change the name of the user
  $("#change_name_user_button").on("click", function () {
    const new_first_name_user = $("#new_first_name_user").val();
    const new_last_name_user = $("#new_last_name_user").val();

    if (
      $.trim(new_first_name_user) === "" ||
      new_first_name_user === undefined ||
      $.trim(new_last_name_user) === "" ||
      new_last_name_user === undefined
    ) {
      return;
    }

    $.ajax({
      type: "POST",
      url: "php/change_name_user.php",
      data: {
        new_first_name_user: new_first_name_user,
        new_last_name_user: new_last_name_user,
      },
      success: function (response) {
        if (response == true) {
          Toastify({
            text: "Name changed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $("#close_change_name_user_modal").click();

          $("#name_user").html(`${new_first_name_user} ${new_last_name_user}`);

          $("#new_first_name_user").val(new_first_name_user);
          $("#new_last_name_user").val(new_last_name_user);

          $("#new_first_name_user").attr("data-old-value", new_first_name_user);
          $("#new_last_name_user").attr("data-old-value", new_last_name_user);
        } else {
          Toastify({
            text: "Error: change name user",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
          $("#close_change_name_user_modal").click();
        }
      },
    });
  });

  //Button to open the modal to change the email of the user
  $("#open_change_email_user_modal").on("click", function () {
    document.getElementById("change_email_user_modal").showModal();
  });

  //Button to close the modal to change the email of the user
  $("#close_change_email_user_modal").on("click", function () {
    document.getElementById("change_email_user_modal").close();
    $("#new_email_user").val($("#new_email_user").attr("data-old-value"));
    $("#change_email_user_button").prop("disabled", false);
    $("#change_email_user_button").removeClass("!text-gray-400");
    $("#change_email_user_button").removeClass("!bg-slate-100");
  });

  //Check of the email of the user value
  $("#new_email_user").on("keyup", function () {
    const email_user = $(this).val();
    if ($.trim(email_user) === "" || email_user === undefined) {
      $("#change_email_user_button").prop("disabled", true);
      $("#change_email_user_button").addClass("!text-gray-400");
      $("#change_email_user_button").addClass("!bg-slate-100");
    } else {
      $("#change_email_user_button").prop("disabled", false);
      $("#change_email_user_button").removeClass("!text-gray-400");
      $("#change_email_user_button").removeClass("!bg-slate-100");
    }
  });

  //Button to change the email of the user
  $("#change_email_user_button").on("click", function () {
    const new_email_user = $("#new_email_user").val();

    if ($.trim(new_email_user) === "" || new_email_user === undefined) {
      return;
    }

    $.ajax({
      type: "POST",
      url: "php/change_email_user.php",
      data: {
        new_email_user: new_email_user,
      },
      success: function (response) {
        if (response == true) {
          Toastify({
            text: "Email changed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $("#close_change_email_user_modal").click();

          $("#email_user").html(new_email_user);
          $("#new_email_user").val(new_email_user);
          $("#new_email_user").attr("data-old-value", new_email_user);
        } else {
          Toastify({
            text: "Error: change email user",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
          $("#close_change_email_user_modal").click();
        }
      },
    });
  });

  //Button to open the modal to change the image of the user
  $("#open_change_image_user_modal").on("click", function () {
    document.getElementById("change_image_user_modal").showModal();
  });

  //Button to close the modal to change the image of the user
  $("#close_change_image_user_modal").on("click", function () {
    document.getElementById("change_image_user_modal").close();
    $("#input_image_user").val("");
  });

  //Button to open the input file for the image of the user
  $("#open_input_image_user_button, #current_image_user").on(
    "click",
    function () {
      $("#input_image_user").click();
    }
  );

  //Change of the image of the user
  $("#input_image_user").on("change", function () {
    const files = this.files;

    if (files.length == 0 || files.length > 1) {
      Toastify({
        text: "Error: choose one image",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      return;
    }

    const type = files[0].type;
    const size = parseFloat(
      (parseFloat(files[0].size) * 0.00000095367432).toFixed(2)
    ); //convertion from bytes to MB
    const accepted_size = 5; //5 MB

    if (!validTypeImage(type)) {
      Toastify({
        text: "Error: choose a valid image",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      return;
    }

    if (size > accepted_size) {
      Toastify({
        text: "Error: image size too big",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      return;
    }

    const formData = new FormData();
    formData.append("new_image_user", files[0]);

    $.ajax({
      type: "POST",
      url: "php/change_image_user.php",
      processData: false,
      contentType: false,
      data: formData,
      success: function (response) {
        if (response.result == true) {
          Toastify({
            text: "Image changed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $(".image-user").attr("src", response.new_image_user);
          $("#input_image_user").val("");
          $("#close_change_image_user_modal").click();
        } else if (response.result == -1) {
          Toastify({
            text: "Error: image's error",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $("#close_change_image_user_modal").click();
        } else if (response.result == -2) {
          Toastify({
            text: "Error: the file has not been created",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $("#close_change_image_user_modal").click();
        } else {
          Toastify({
            text: "Error: change image user",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          $("#close_change_image_user_modal").click();
        }
      },
    });
  });
});

//Function to check the image type
function validTypeImage(type) {
  const typesImage = ["image/jpeg", "image/png"];
  return typesImage.includes(type);
}
