$(document).ready(function () {
  document.title = "New Password";

  //Button to show and hide the password
  $(".show-password").on("click", function () {
    const eye_opened = $(this).find(".eye-opened");
    const eye_closed = $(this).find(".eye-closed");

    if ($(eye_opened).hasClass("hidden")) {
      $(eye_opened).removeClass("hidden");
      $(eye_closed).addClass("hidden");
      $(this).parent().find("input[type='password']").attr("type", "text");
    } else {
      $(eye_opened).addClass("hidden");
      $(eye_closed).removeClass("hidden");
      $(this).parent().find("input[type='text']").attr("type", "password");
    }
  });

  //Button to change the password
  $("#change_password_button").on("click", function () {
    const inputs = $("#change_password_form").find("input:required");
    const password_user = $("#password_user").val();
    const confirm_password_user = $("#confirm_password_user").val();
    let validation = 0;

    //Checking if the inputs are empty
    for (let i = 0; i < inputs.length; i++) {
      let value = $(inputs[i]).val();
      if ($.trim(value) === "" || value === undefined) {
        $(inputs[i])
          .parents(".input-area")
          .find(".error-message")
          .removeClass("hidden");
        validation = 0;
      } else {
        $(inputs[i])
          .parents(".input-area")
          .find(".error-message")
          .addClass("hidden");
        validation++;
      }
    }

    //Checking if the passwords are the same
    if (password_user !== confirm_password_user) {
      Toastify({
        text: "Error: the passwords must be the same",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      $("#password_user").addClass("!border-red-500");
      $("#confirm_password_user").addClass("!border-red-500");
      validation = 0;
    } else {
      $("#password_user").removeClass("!border-red-500");
      $("#confirm_password_user").removeClass("!border-red-500");
    }

    //If every input is ok, I change the password
    if (validation === inputs.length) {
      $.ajax({
        type: "POST",
        url: "php/change_password_user.php",
        data: $("#change_password_form").serialize(),
        success: function (response) {
          if (response == 1) {
            Toastify({
              text: "Password changed",
              duration: 6000,
              className: "bg-zinc-800 rounded",
              gravity: "bottom",
              position: "left",
            }).showToast();

            $("#change_password_form").addClass("hidden");
            $("#success_password_box").removeClass("hidden");

            //Send email to confirm the changed password
            $.ajax({
              type: "POST",
              url: "php/send_email_change_password_user.php",
              data: {
                email_user: $("#email_user").val(),
              },
              success: function (response) {
                if (response != 1) {
                  Toastify({
                    text: "Error: send email to confirm the changed password",
                    duration: 6000,
                    className: "bg-red-500 rounded",
                    gravity: "bottom",
                    position: "left",
                  }).showToast();
                }
              },
            });
          } else if (response == -1) {
            Toastify({
              text: "Error: the informations are not valids",
              duration: 6000,
              className: "bg-red-500 rounded",
              gravity: "bottom",
              position: "left",
            }).showToast();
          } else {
            Toastify({
              text: "Error: change password",
              duration: 6000,
              className: "bg-red-500 rounded",
              gravity: "bottom",
              position: "left",
            }).showToast();
          }
        },
      });
    }
  });
});
