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

  //Log In Button
  $("#log_in_button").on("click", function () {
    const inputs = $("#log_in_form").find("input:required");
    let validation = 0;

    //Checking if the inputs are empty
    for (let i = 0; i < inputs.length; i++) {
      let value = $(inputs[i]).val();
      if ($.trim(value) === "" || value === undefined) {
        $(inputs[i]).next(".error-message").removeClass("hidden");
        $(inputs[i]).addClass("!border-red-500");
        validation = 0;
      } else {
        $(inputs[i]).next(".error-message").addClass("hidden");
        $(inputs[i]).removeClass("!border-red-500");
        validation++;
      }
    }

    //If every input is ok, the user can log in
    if (validation === inputs.length) {
      $.ajax({
        type: "POST",
        url: "php/login_user.php",
        data: $("#log_in_form").serialize(),
        success: function (response) {
          if (response > 0) {
            window.location.href = "index.php";
          } else if (response == -1) {
            Toastify({
              text: "Error: the informations don't match",
              duration: 6000,
              className: "bg-red-500 rounded",
              gravity: "bottom",
              position: "left",
            }).showToast();
            $("#email_user").addClass("border-red-500");
            $("#password_user").addClass("border-red-500");
          } else {
            Toastify({
              text: "Error: login",
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
