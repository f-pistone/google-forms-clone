$(document).ready(function () {
  document.title = $("#title_form").text();

  //
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
