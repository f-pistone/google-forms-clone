$(document).ready(function () {
  //Log In Button
  $("#log_in_button").on("click", function () {
    const inputs = $("#log_in_form").find("input:required");
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
            console.log("Data don't match");
            $("#email_user").addClass("border-red-500");
            $("#password_user").addClass("border-red-500");
          } else {
            console.log("Error");
          }
        },
      });
    }
  });
});
