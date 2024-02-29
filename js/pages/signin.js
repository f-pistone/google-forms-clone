$(document).ready(function () {
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

  //Sign In Button
  $("#sign_in_button").on("click", function () {
    const inputs = $("#sign_in_form").find("input:required");
    const password_user = $("#password_user").val();
    const confirm_password_user = $("#confirm_password_user").val();
    let validation = 0;

    //Checking if the inputs are empty
    for (let i = 0; i < inputs.length; i++) {
      let value = $(inputs[i]).val();
      if ($.trim(value) === "" || value === undefined) {
        $(inputs[i]).next(".error-message").removeClass("hidden");
        validation = 0;
      } else {
        $(inputs[i]).next(".error-message").addClass("hidden");
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
      $("#password_user").addClass("border-red-500");
      $("#confirm_password_user").addClass("border-red-500");
      validation = 0;
    } else {
      $("#password_user").removeClass("border-red-500");
      $("#confirm_password_user").removeClass("border-red-500");
    }

    //If every input is ok, I create the new user
    if (validation === inputs.length) {
      $.ajax({
        type: "POST",
        url: "php/create_user.php",
        data: $("#sign_in_form").serialize(),
        success: function (response) {
          console.log(response);
          if (response > 0) {
            window.location.href = "index.php";
          } else if (response == -1) {
            Toastify({
              text: "Error: email already used",
              duration: 6000,
              className: "bg-red-500 rounded",
              gravity: "bottom",
              position: "left",
            }).showToast();
            $("#email_user").addClass("border-red-500");
          } else {
            Toastify({
              text: "Error: create user",
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
