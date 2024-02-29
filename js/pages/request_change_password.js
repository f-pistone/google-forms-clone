$(document).ready(function () {
  document.title = "Request Change Password";

  //Button to send the email to change the password
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
        email_user: email_user,
      },
      success: function (response) {
        if (response == 1) {
          Toastify({
            text: "Email sent",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
          $("#send_email_box").addClass("hidden");
          $("#success_email_box").removeClass("hidden");
        } else if (response == -1) {
          Toastify({
            text: "Error: this email is not associated to any account",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        } else {
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
