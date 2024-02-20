$(document).ready(function () {
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
      $("#password_user").addClass("border-red-500");
      $("#confirm_password_user").addClass("border-red-500");
      validation = 0;
      alert("The passwords must to be the same.");
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
            $("#email_user").addClass("border-red-500");
            console.log("Email already used");
          } else {
            console.log("Error");
          }
        },
      });
    }
  });
});
