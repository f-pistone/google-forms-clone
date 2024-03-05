$(document).ready(function () {
  document.title = $("#title_form").text();

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

    $.ajax({
      type: "POST",
      url: "php/send_form.php",
      data: {
        id_form: id_form,
        sections: sections,
      },
      success: function (response) {},
    });
  });
});

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
