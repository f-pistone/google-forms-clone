$(document).ready(function () {
  document.title = $("#title_form").text();

  //Check the value of the required question's text input
  $("#form").on(
    "keyup focusout",
    "input[type='text'].answer-required, textarea.answer-required",
    function () {
      const value = $(this).val();
      const question = $(this).parents(".question");
      if ($.trim(value) == "") {
        $(this).addClass("!border-red-500");
        $(question).addClass("!border-red-500");
        $(question).find(".error-message").removeClass("hidden");
      } else {
        $(this).removeClass("!border-red-500");
        $(question).removeClass("!border-red-500");
        $(question).find(".error-message").addClass("hidden");
      }
    }
  );

  //Check the value of the required question's radio and checkbox input
  $("#form").on(
    "click",
    "input[type='radio'].answer-required, input[type='checkbox'].answer-required",
    function () {
      const question = $(this).parents(".question");
      const answers_checked = $(question).find(".answer:checked");
      const other_option_checked = $(question).find(".other-option:checked");
      const text_other_option = $(question)
        .find(".text-other-option-required")
        .val();

      if (
        answers_checked.length == 0 ||
        (other_option_checked.length == 1 && $.trim(text_other_option) == "")
      ) {
        $(question).addClass("!border-red-500");
        $(question).find(".error-message").removeClass("hidden");
      } else {
        $(question).removeClass("!border-red-500");
        $(question).find(".error-message").addClass("hidden");
      }
    }
  );

  //Check the value of the required question's select
  $("#form").on("change click", "select.answer-required", function () {
    const value = $(this).val();
    const question = $(this).parents(".question");
    if ($.trim(value) == "") {
      $(question).addClass("!border-red-500");
      $(question).find(".error-message").removeClass("hidden");
    } else {
      $(question).removeClass("!border-red-500");
      $(question).find(".error-message").addClass("hidden");
    }
  });

  //Check the value of the required question's input other option
  $("#form").on("keyup focusout", ".text-other-option-required", function () {
    const value = $(this).val();
    const question = $(this).parents(".question");
    const answers_checked = $(question).find(".answer:checked");
    const other_option_checked = $(question).find(".other-option:checked");

    if (
      other_option_checked.length == 1 &&
      $.trim(value) == "" &&
      answers_checked.length == 0
    ) {
      $(question).addClass("!border-red-500");
      $(question).find(".error-message").removeClass("hidden");
    } else {
      $(question).removeClass("!border-red-500");
      $(question).find(".error-message").addClass("hidden");
    }

    if (other_option_checked.length == 0 && $.trim(value) != "") {
      $(question).find(".other-option").prop("checked", true);
    }
  });

  //Show the remove selected button when you click on a radio or checkbox of a not required question
  $("#form").on(
    "click",
    "input[type='radio'].answer, input[type='checkbox'].answer",
    function () {
      const question = $(this).parents(".question");
      $(question).find(".remove-selected").parent().removeClass("hidden");
    }
  );

  //Unchecked the answers of the not required question
  $("#form").on("click", ".remove-selected", function () {
    const question = $(this).parents(".question");
    $(question).find(".answer").prop("checked", false);
    $(this).parent().addClass("hidden");
  });

  //Button to go at the next section
  $("#next_step_button").on("click", function () {
    const activeSection = $("#form").find(".section.block");
    const nextSection = $(activeSection).next(".section");

    $(activeSection).removeClass("block");
    $(activeSection).addClass("hidden");

    $(nextSection).removeClass("hidden");
    $(nextSection).addClass("block");

    updateFormStatus();
  });

  //Button to go at the previous section
  $("#prev_step_button").on("click", function () {
    const activeSection = $("#form").find(".section.block");
    const prevSection = $(activeSection).prev(".section");

    $(activeSection).removeClass("block");
    $(activeSection).addClass("hidden");

    $(prevSection).removeClass("hidden");
    $(prevSection).addClass("block");

    updateFormStatus();
  });

  //Button to send the form
  $("#send_form_button").on("click", function () {
    const id_form = $("#form").attr("data-id-form");
    const sectionsEl = $(".section");
    const sections = [];
    const email_user_result = $("#email_user_result").val();
    const not_answered = checkNotAnsweredRequiredQuestions();

    //Check if the user inserted his email
    if ($.trim(email_user_result) == "") {
      Toastify({
        text: "Error: you have insert your email to send the form",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      $("#email_user_result").addClass("!border-red-500");
      return;
    } else {
      $("#email_user_result").removeClass("!border-red-500");
    }

    //Check if the user answered to all the required questions
    if (not_answered > 0) {
      Toastify({
        text: "Error: you have to responde to all the required questions",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      return;
    }

    //Sections
    for (let i = 0; i < sectionsEl.length; i++) {
      let id_section = $(sectionsEl[i]).attr("data-id-section");
      let questionsEl = $(sectionsEl[i]).find(".question");
      let questions = [];

      //Questions of the sections
      for (let j = 0; j < questionsEl.length; j++) {
        let id_question = $(questionsEl[j]).attr("data-id-question");
        let type_question = $(questionsEl[j]).attr("data-type-question");

        //Short answer
        if (type_question == "SHORT_ANSWER") {
          let answer = "";
          answer = $(questionsEl[j]).find(".answer").val();
          questions.push({
            id_question,
            type_question,
            answer,
          });
        }

        //Long answer
        if (type_question == "LONG_ANSWER") {
          let answer = "";
          answer = $(questionsEl[j]).find(".answer").val();
          questions.push({
            id_question,
            type_question,
            answer,
          });
        }

        //Multiple choise
        if (type_question == "MULTIPLE_CHOISE") {
          let answer = "";
          let option_checked = $(questionsEl[j]).find(".answer:checked");
          let id_option = $(option_checked).val();
          //Option checked
          if ($(option_checked).hasClass("other-option")) {
            let name_option = $(questionsEl[j])
              .find(".text-other-option")
              .val();
            answer = {
              id_option,
              name_option,
              other_option: 1,
            };
          } else {
            answer = id_option;
          }
          questions.push({
            id_question,
            type_question,
            answer,
          });
        }

        //Checkbox
        if (type_question == "CHECKBOX") {
          let answer = [];
          let options_checked = $(questionsEl[j]).find(".answer:checked");
          //Options checked
          for (let k = 0; k < options_checked.length; k++) {
            let id_option = $(options_checked[k]).val();
            if ($(options_checked[k]).hasClass("other-option")) {
              let name_option = $(questionsEl[j])
                .find(".text-other-option")
                .val();
              answer.push({
                id_option,
                name_option,
                other_option: 1,
              });
            } else {
              answer.push(id_option);
            }
          }
          questions.push({
            id_question,
            type_question,
            answer,
          });
        }

        //List
        if (type_question == "LIST") {
          let answer = "";
          answer = $(questionsEl[j]).find(".answer").val();
          questions.push({
            id_question,
            type_question,
            answer,
          });
        }
      }

      sections.push({
        id_section,
        questions,
      });
    }

    //Create result
    $.ajax({
      type: "POST",
      url: "php/create_result.php",
      data: {
        email_user_result: email_user_result,
        id_form: id_form,
        sections: sections,
      },
      success: function (response) {
        if (response > 0) {
          Toastify({
            text: "Result saved",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();

          //Send result email
          $.ajax({
            type: "POST",
            url: "php/send_emails_result.php",
            data: {
              email_user_result: email_user_result,
              id_form: id_form,
            },
            success: function (response) {},
          });
        } else {
          Toastify({
            text: "Error: create result",
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

//Check if the user answered to all the required questions
function checkNotAnsweredRequiredQuestions() {
  const questions = $("#form").find(".question-required");
  let not_answered = 0;

  //Questions
  for (let i = 0; i < questions.length; i++) {
    let question = $(questions[i]);
    let type_question = $(question).attr("data-type-question");

    //Short answer and Long answer
    if (type_question == "SHORT_ANSWER" || type_question == "LONG_ANSWER") {
      let value = $(question).find(".answer-required").val();
      if ($.trim(value) == "") {
        $(question).find(".answer-required").addClass("!border-red-500");
        $(question).addClass("!border-red-500");
        $(question).find(".error-message").removeClass("hidden");
        not_answered++;
      } else {
        $(question).find(".answer-required").removeClass("!border-red-500");
        $(question).removeClass("!border-red-500");
        $(question).find(".error-message").addClass("hidden");
      }
    }

    //Multiple choise and Checkbox
    if (type_question == "MULTIPLE_CHOISE" || type_question == "CHECKBOX") {
      let answers_checked = $(question).find(".answer:checked");
      let other_option_checked = $(question).find(".other-option:checked");
      let text_other_option = $(question)
        .find(".text-other-option-required")
        .val();

      if (
        answers_checked.length == 0 ||
        (other_option_checked.length == 1 && $.trim(text_other_option) == "")
      ) {
        $(question).addClass("!border-red-500");
        $(question).find(".error-message").removeClass("hidden");
        not_answered++;
      } else {
        $(question).removeClass("!border-red-500");
        $(question).find(".error-message").addClass("hidden");
      }
    }

    //List
    if (type_question == "LIST") {
      let value = $(question).find(".answer-required").val();
      if ($.trim(value) == "") {
        $(question).addClass("!border-red-500");
        $(question).find(".error-message").removeClass("hidden");
        not_answered++;
      } else {
        $(question).removeClass("!border-red-500");
        $(question).find(".error-message").addClass("hidden");
      }
    }

    return not_answered;
  }
}

//Update the form's status
function updateFormStatus() {
  updateCurrentPage();
  hideShowPrevButton();
  hideShowNextButton();
  hideShowSendButton();
  updateProgressBar();
}

//Update the current page
function updateCurrentPage() {
  const sections = $(".section");
  let currentPage = 0;
  for (let i = 0; i < sections.length; i++) {
    if ($(sections[i]).hasClass("block")) {
      currentPage = i + 1;
    }
  }
  $("#current_page").text(currentPage);
}

//Update the progress bar
function updateProgressBar() {
  const currentPage = parseInt($("#current_page").text());
  const totalPages = parseInt($("#total_pages").text());
  const currentProgressWidth =
    parseFloat((100 * currentPage) / totalPages) + "%";

  $("#current_progress").width(currentProgressWidth);

  if (currentPage == totalPages) {
    $("#current_progress").removeClass("bg-blue-500");
    $("#current_progress").addClass("bg-green-600");
  } else {
    $("#current_progress").removeClass("bg-green-600");
    $("#current_progress").addClass("bg-blue-500");
  }
}

//Hide and show of the previous step button
function hideShowPrevButton() {
  const currentPage = $("#current_page").text();
  const prev_step_button = $("#prev_step_button");
  if (currentPage > 1) {
    $(prev_step_button).show();
  } else {
    $(prev_step_button).hide();
  }
}

//Hide and show of the next step button
function hideShowNextButton() {
  const currentPage = $("#current_page").text();
  const lastPage = $("#total_pages").text();
  const next_step_button = $("#next_step_button");
  if (currentPage < lastPage) {
    $(next_step_button).show();
  } else {
    $(next_step_button).hide();
  }
}

//Hide and show of the send form button
function hideShowSendButton() {
  const currentPage = $("#current_page").text();
  const lastPage = $("#total_pages").text();
  const send_form_button = $("#send_form_button");
  if (currentPage == lastPage) {
    send_form_button.show();
  } else {
    send_form_button.hide();
  }
}
