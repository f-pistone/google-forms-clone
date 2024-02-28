$(document).ready(function () {
  document.title = "Change Password";

  //
  $("#send_email_button").on("click", function () {
    const email_user = $("#email_user").val();

    if ($.trim(email_user) == "" || email_user == undefined) {
      $("#email_user").addClass("!border-red-500");
      $("#email_user").next(".error-message").removeClass("hidden");
      return;
    } else {
      $("#email_user").removeClass("!border-red-500");
      $("#email_user").next(".error-message").addClass("hidden");
    }

    $.ajax({
      type: "POST",
      url: "php/send_email_change_password.php",
      data: {
        email_user: email_user
      },
      success: function(response) {
        
      }
    });

  });
});
