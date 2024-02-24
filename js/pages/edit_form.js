$(document).ready(function () {
  document.title = $("#header_title_form").val() + " - Google Forms Clone";

  //Input to rename the form
  $("#header_title_form").on("focusout", function () {
    const input = $(this);
    const current_title_form = $(input).attr("data-current-title-form");
    const new_title_form = $(input).val();
    const id_form = $("#form").attr("data-id-form");

    if ($.trim(new_title_form) === "" || new_title_form === undefined) {
      $(input).val(current_title_form);
      return;
    }

    $.ajax({
      type: "POST",
      url: "php/rename_form.php",
      data: {
        id_form: id_form,
        new_title_form: new_title_form,
      },
      success: function (response) {
        if (response == true) {
          $(input).attr("data-current-title-form", new_title_form);
          document.title = new_title_form + " - Google Forms Clone";
        } else {
          Toastify({
            text: "Error: rename form",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to open the options menu of the form
  $(".open-options-menu").on("click", function () {
    const options_menu_to_open = $(this).next(".options-menu");
    if ($(options_menu_to_open).hasClass("hidden")) {
      $(options_menu_to_open).removeClass("hidden");
    } else {
      $(options_menu_to_open).addClass("hidden");
    }
  });

  //Button to open the options menu of the section
  $("#form").on("click", ".open-options-section", function () {
    const options_section_to_open = $(this).next(".options-section");
    if ($(options_section_to_open).hasClass("hidden")) {
      $(options_section_to_open).removeClass("hidden");
    } else {
      $(options_section_to_open).addClass("hidden");
    }
  });

  //Button to add a new question
  $("#add_question_button").on("click", function () {
    const last_section = $(".section").last();
    const id_last_section = $(last_section).attr("data-id-section");
    const last_section_question = $(last_section).find(".question").last();

    $.ajax({
      type: "POST",
      url: "php/create_question.php",
      data: {
        id_section: id_last_section,
      },
      success: function (response) {
        if (response > 0) {
          const new_question = createQuestion(response);

          if (last_section_question.length > 0) {
            $(last_section_question).after(new_question);
          } else {
            $(last_section).find(".section-info").after(new_question);
          }
        } else {
          Toastify({
            text: "Error: create question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to add a new section
  $("#add_section_button").on("click", function () {
    const id_form = $("#form").attr("data-id-form");

    $.ajax({
      type: "POST",
      url: "php/create_section.php",
      data: {
        id_form: id_form,
      },
      success: function (response) {
        if (response > 0) {
          const last_section = $(".section").last();
          const new_section = createSection(response);
          $(last_section).after(new_section);
          updateSectionsNumber();
        }
      },
    });
  });

  //Button to remove a section
  $("#remove_section_button").on("click", function () {
    const number_of_sections = $(".section").length;
    const id_section = $("#id_section_to_remove").val();

    if (number_of_sections == 1) {
      Toastify({
        text: "Error: the form needs at least one section",
        duration: 6000,
        className: "bg-red-500 rounded",
        gravity: "bottom",
        position: "left",
      }).showToast();
      $("#close_remove_section_modal").click();
      return;
    }

    $.ajax({
      type: "POST",
      url: "php/remove_section.php",
      data: {
        id_section: id_section,
      },
      success: function (response) {
        if (response == true) {
          $(`.section[data-id-section=${id_section}]`).remove();
          $("#close_remove_section_modal").click();
          updateSectionsNumber();
          Toastify({
            text: "Section removed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        } else {
          Toastify({
            text: "Error: remove section",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Toggle the active class for the form boxes
  $("#form").on("click", ".form-box", function () {
    $(".form-box").removeClass("active-form-box");
    $(this).addClass("active-form-box");
  });

  //Input to rename a section
  $("#form").on("focusout", ".section-title", function () {
    const id_section = $(this).parents(".section").attr("data-id-section");
    const new_title_section = $(this).val();
    $.ajax({
      type: "POST",
      url: "php/rename_section.php",
      data: {
        id_section: id_section,
        new_title_section: new_title_section,
      },
      success: function (response) {
        if (response != true) {
          Toastify({
            text: "Error: rename section",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Textarea to change the description of a section
  $("#form").on("focusout", ".section-description", function () {
    const id_section = $(this).parents(".section").attr("data-id-section");
    const new_description_section = $(this).val();
    $.ajax({
      type: "POST",
      url: "php/change_description_section.php",
      data: {
        id_section: id_section,
        new_description_section: new_description_section,
      },
      success: function (response) {
        if (response != true) {
          Toastify({
            text: "Error: change section's description",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Input to rename a question
  $("#form").on("focusout", ".question-name", function () {
    const id_question = $(this).parents(".question").attr("data-id-question");
    const new_name_question = $(this).val();
    $.ajax({
      type: "POST",
      url: "php/rename_question.php",
      data: {
        id_question: id_question,
        new_name_question: new_name_question,
      },
      success: function (response) {
        if (response != true) {
          Toastify({
            text: "Error: rename question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Change of the question's type
  $("#form").on("change", ".type-question", function () {
    const question = $(this).parents(".question");
    const id_question = $(question).attr("data-id-question");
    const new_type_question = $(this).val();
    let new_question_body = "";

    if (new_type_question == "SHORT_ANSWER") {
      new_question_body = createBodyShortAnswerQuestion();
    }

    if (new_type_question == "LONG_ANSWER") {
      new_question_body = createBodyLongAnswerQuestion();
    }

    if (new_type_question == "MULTIPLE_CHOISE") {
      new_question_body = createBodyMultipleChoiseAnswerQuestion();
    }

    if (new_type_question == "CHECKBOX") {
      new_question_body = createBodyCheckboxAnswerQuestion();
    }

    if (new_type_question == "LIST") {
      new_question_body = createBodyListAnswerQuestion();
    }

    $.ajax({
      type: "POST",
      url: "php/change_type_question.php",
      data: {
        id_question: id_question,
        new_type_question: new_type_question,
      },
      success: function (response) {
        if (response == true) {
          $(question).find(".question-body").html(new_question_body);
          updateQuestionAnswer(question);
        } else {
          Toastify({
            text: "Error: change type question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to duplicate a question
  $("#form").on("click", ".duplicate-question-button", function () {
    const question = $(this).parents(".question");
    const id_question = $(question).attr("data-id-question");

    $.ajax({
      type: "POST",
      url: "php/duplicate_question.php",
      data: {
        id_question_to_clone: id_question,
      },
      success: function (response) {
        if (response > 0) {
          const section = $(question).parents(".section");
          const type_question_value = $(question).find(".type-question").val();
          const question_clone = $(question).clone();
          $(question_clone).find(".type-question").val(type_question_value);
          $(question_clone).attr("data-id-question", response);
          $(question).after(question_clone);
          updateSectionOrderQuestions(section);
        } else {
          Toastify({
            text: "Error: duplicate question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to remove a question
  $("#form").on("click", ".remove-question-button", function () {
    const question = $(this).parents(".question");
    const id_question = $(question).attr("data-id-question");
    const section = $(question).parents(".section");

    $.ajax({
      type: "POST",
      url: "php/remove_question.php",
      data: {
        id_question: id_question,
      },
      success: function (response) {
        if (response == true) {
          $(question).remove();
          updateSectionOrderQuestions(section);
          Toastify({
            text: "Element removed",
            duration: 6000,
            className: "bg-zinc-800 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        } else {
          Toastify({
            text: "Error: remove question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Button to add a new option for the question
  $("#form").on("click", ".add-option-button", function () {
    const question = $(this).parents(".question");
    const type_question = $(question).find(".type-question").val();
    const add_options_menu = $(question).find(".add-options-menu");
    const other_option = $(question).find(".other-option");

    //Checking which option I need to create
    if (type_question == "MULTIPLE_CHOISE") {
      const option = createOptionMultipleChoiseAnswerQuestion();
      if (other_option.length > 0) {
        $(other_option).before(option);
      } else {
        $(add_options_menu).before(option);
      }
      updateQuestionAnswer(question);
    }

    if (type_question == "CHECKBOX") {
      const option = createOptionCheckboxAnswerQuestion();
      if (other_option.length > 0) {
        $(other_option).before(option);
      } else {
        $(add_options_menu).before(option);
      }
      updateQuestionAnswer(question);
    }

    if (type_question == "LIST") {
      const option = createOptionListAnswerQuestion();
      $(add_options_menu).before(option);
      updateQuestionAnswer(question);
    }
  });

  //Button to add the other option for the question
  $("#form").on("click", ".add-other-option-button", function () {
    const question = $(this).parents(".question");
    const type_question = $(question).find(".type-question").val();
    const add_options_menu = $(question).find(".add-options-menu");
    const other_option_exist = $(question).find(".other-option");

    if (other_option_exist.length > 0) {
      return;
    }

    if (type_question == "MULTIPLE_CHOISE") {
      const option = createOtherOptionMultipleChoiseAnswerQuestion();
      $(add_options_menu).before(option);
      $(this).prev("span").hide();
      $(this).hide();
      updateQuestionAnswer(question);
      return;
    }

    if (type_question == "CHECKBOX") {
      const option = createOtherOptionCheckboxAnswerQuestion();
      $(add_options_menu).before(option);
      $(this).prev("span").hide();
      $(this).hide();
      updateQuestionAnswer(question);
      return;
    }
  });

  //Button to remove an option of the question
  $("#form").on("click", ".remove-option-button", function () {
    const question = $(this).parents(".question");
    const option = $(this).parents(".option");

    if ($(option).hasClass("other-option")) {
      const add_other_option_button = $(question).find(
        ".add-other-option-button"
      );
      $(add_other_option_button).prev("span").show();
      $(add_other_option_button).show();
    }

    $(option).remove();
    updateQuestionAnswer(question);
  });

  //Update the question's option's value
  $("#form").on("focusout", ".option-value", function () {
    const question = $(this).parents(".question");
    updateQuestionAnswer(question);
  });

  //Button to open the modal to remove a section
  $("#form").on("click", ".open-remove-section-modal", function () {
    const id_section_to_remove = $(this)
      .parents(".section")
      .attr("data-id-section");
    $("#id_section_to_remove").val(id_section_to_remove);
    document.getElementById("remove_section_modal").showModal();
  });

  //Button to close the modal to remove a section
  $("#close_remove_section_modal").on("click", function () {
    $("#id_section_to_remove").val("");
    document.getElementById("remove_section_modal").close();
  });

  //Button to set the question as required
  $("#form").on("click", ".question-required", function () {
    const question = $(this).parents(".question");
    const id_question = $(question).attr("data-id-question");
    const required_question = $(this).is(":checked") ? 1 : 0;

    $.ajax({
      type: "POST",
      url: "php/update_required_question.php",
      data: {
        id_question: id_question,
        required_question: required_question,
      },
      success: function (response) {
        if (response != true) {
          Toastify({
            text: "Error: update required question",
            duration: 6000,
            className: "bg-red-500 rounded",
            gravity: "bottom",
            position: "left",
          }).showToast();
        }
      },
    });
  });

  //Questions when the drag starts
  $("#form").on("dragstart", ".question", function () {
    $(this).addClass("dragging");
    $(this).addClass("opacity-50");
  });

  //Questions when the drag ends
  $("#form").on("dragend", ".question", function () {
    const section = $(this).parents(".section");
    updateSectionOrderQuestions(section);

    $(this).removeClass("dragging");
    $(this).removeClass("opacity-50");
  });

  //Sections on drag
  $("#form").on("dragover", ".section", function (e) {
    e.preventDefault();

    const after_element = getDragAfterElement(this, e.clientY);
    const question_on_drag = $(".dragging");

    if (after_element == undefined) {
      $(this).append(question_on_drag);
    } else {
      $(after_element).before(question_on_drag);
    }
  });
});

//Create a new question
function createQuestion(id_question) {
  const new_question = `            
  <!-- QUESTION SHORT ANSWER -->
  <div class="question form-box relative p-7 rounded-md bg-white shadow flex flex-col gap-4" draggable="true" data-id-question="${id_question}">

    <!-- QUESTION HEADER -->
    <div class="question-header flex flex-wrap justify-start md:justify-between items-center gap-5">
      <div class="basis-full md:basis-6/12">
        <input type="text" class="question-name p-4 w-full bg-gray-100 border-b border-gray-500 focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Question" value="">
      </div>
      <div class="basis-full md:basis-5/12">
        <select class="type-question p-4 w-full cursor-pointer border rounded focus:outline-none">
          <option value="SHORT_ANSWER" selected>Short answer</option>
          <option value="LONG_ANSWER">Long answer</option>
          <option value="MULTIPLE_CHOISE">Multiple choise</option>
          <option value="CHECKBOX">Checkbox</option>
          <option value="LIST">List</option>
        </select>
      </div>
    </div>
    <!-- END QUESTION HEADER -->

    <!-- QUESTION BODY -->
    <div class="question-body mb-10">
      <p class="border-dotted border-b border-gray-500 text-gray-500">Short answer</p>
    </div>
    <!-- END QUESTION BODY -->

    <!-- QUESTION FOOTER -->
    <div class="question-footer pt-2 border-t border-gray-300 flex justify-end items-center gap-3">
      <div class="pr-2 border-r border-gray-300 flex items-center gap-1">
        <button type="button" class="duplicate-question-button p-3 w-[50px] aspect-square rounded-full flex justify-center items-center text-lg transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
            <path fill="currentColor" fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
          </svg>
        </button>
        <button type="button" class="remove-question-button p-3 w-[50px] aspect-square rounded-full flex justify-center items-center text-lg transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" />
            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" />
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224l8 224m136-224l-8 224" />
          </svg>
        </button>
      </div>
      <div class="pl-2 flex items-center gap-2">
        <span>Required</span>
        <input class="question-required switch" type="checkbox" value="1">
      </div>
    </div>
    <!-- END QUESTION FOOTER -->

  </div>
  <!-- END QUESTION SHORT ANSWER -->
  `;
  return new_question;
}

//Create the body for the question with a short answer
function createBodyShortAnswerQuestion() {
  const body = `<p class="border-dotted border-b border-gray-500 text-gray-500">Short answer</p>`;
  return body;
}

//Create the body for the question with a long answer
function createBodyLongAnswerQuestion() {
  const body = `<p class="border-dotted border-b border-gray-500 text-gray-500">Long answer</p>`;
  return body;
}

//Create the body for the question with a multiple choise answer
function createBodyMultipleChoiseAnswerQuestion() {
  const body = `
  <ul class="flex flex-col gap-1">
    <!-- OPTION -->
    <li class="option h-[40px] flex items-center gap-3">
      <div class="shrink-0 text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
        </svg>
      </div>
      <div class="grow">
        <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
            <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
          </svg>
        </button>
      </div>
    </li>
    <!-- END OPTION -->
    <!-- ADD OPTIONS MENU -->
    <li class="add-options-menu h-[40px] flex items-center gap-3">
      <div class="text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
        </svg>
      </div>
      <div class="flex items-center gap-1">
        <button type="button" class="add-option-button p-1 text-gray-500 hover:border-b">
          Add option
        </button>
        <span>or</span>
        <button type="button" class="add-other-option-button p-1 rounded text-blue-500 hover:bg-blue-100">
          add "Other"
        </button>
      </div>
    </li>
    <!-- END ADD OPTIONS MENU -->
  </ul>
`;
  return body;
}

//Create the body for the question with a checkbox answer
function createBodyCheckboxAnswerQuestion() {
  const body = `
  <ul class="flex flex-col gap-1">
    <!-- OPTION -->
    <li class="option h-[40px] flex items-center gap-3">
      <div class="shrink-0 text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
          <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
        </svg>
      </div>
      <div class="grow">
        <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
            <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
          </svg>
        </button>
      </div>
    </li>
    <!-- END OPTION -->
    <!-- ADD OPTIONS MENU -->
    <li class="add-options-menu h-[40px] flex items-center gap-3">
      <div class="text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
          <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
        </svg>
      </div>
      <div class="flex items-center gap-1">
        <button type="button" class="add-option-button p-1 text-gray-500 hover:border-b">
          Add option
        </button>
        <span>or</span>
        <button type="button" class="add-other-option-button p-1 rounded text-blue-500 hover:bg-blue-100">
          add "Other"
        </button>
      </div>
    </li>
    <!-- END ADD OPTIONS MENU -->
  </ul>
  `;
  return body;
}

//Create the body for the question with a list answer
function createBodyListAnswerQuestion() {
  const body = `
  <ol class="list-decimal pl-4 flex flex-col gap-1">
    <!-- OPTION -->
    <li class="option pl-1">
      <div class="h-[40px] flex items-center gap-3">
        <div class="grow">
          <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
        </div>
        <div class="shrink-0">
          <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
              <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
            </svg>
          </button>
        </div>
      </div>
    </li>
    <!-- END OPTION -->
    <!-- ADD OPTIONS MENU -->
    <li class="add-options-menu pl-1">
      <div class="h-[40px] flex items-center gap-3">
        <button type="button" class="add-option-button p-1 text-gray-500 hover:border-b">
          Add option
        </button>
      </div>
    </li>
    <!-- END ADD OPTIONS MENU -->
  </ol>
`;
  return body;
}

//Create the option for the question with a multiple choise answer
function createOptionMultipleChoiseAnswerQuestion() {
  const option = `                  
  <!-- OPTION -->
  <li class="option h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
    </div>
    <div class="shrink-0">
      <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
          <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
        </svg>
      </button>
    </div>
  </li>
  <!-- END OPTION -->
  `;
  return option;
}

//Create the option for the question with a checkbox answer
function createOptionCheckboxAnswerQuestion() {
  const option = `
  <!-- OPTION -->
  <li class="option h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
        <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
    </div>
    <div class="shrink-0">
      <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
          <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
        </svg>
      </button>
    </div>
  </li>
  <!-- END OPTION -->
  `;
  return option;
}

//Create the option for the question with a list answer
function createOptionListAnswerQuestion() {
  const option = `
  <!-- OPTION -->
  <li class="option pl-1">
    <div class="h-[40px] flex items-center gap-3">
      <div class="grow">
        <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
            <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
          </svg>
        </button>
      </div>
    </div>
  </li>
  <!-- END OPTION -->
  `;
  return option;
}

//Create the other option for the question with a multiple choise answer
function createOtherOptionMultipleChoiseAnswerQuestion() {
  const other_option = `                  
  <!-- OTHER OPTION -->
  <li class="option other-option h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="option-value w-full text-gray-500 hover:border-dotted hover:border-b hover:border-gray-500 disabled:bg-transparent" placeholder="Other" value="Other" disabled>
    </div>
    <div class="shrink-0">
      <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
          <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
        </svg>
      </button>
    </div>
  </li>
  <!-- END OTHER OPTION -->
  `;
  return other_option;
}

//Create the other option for the question with a checkbox answer
function createOtherOptionCheckboxAnswerQuestion() {
  const other_option = `                  
  <!-- OTHER OPTION -->
  <li class="option other-option h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
        <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="option-value w-full text-gray-500 hover:border-dotted hover:border-b hover:border-gray-500 disabled:bg-transparent" placeholder="Other" value="Other" disabled>
    </div>
    <div class="shrink-0">
      <button type="button" class="remove-option-button p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
          <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z" />
        </svg>
      </button>
    </div>
  </li>
  <!-- END OTHER OPTION -->
  `;
  return other_option;
}

//Create a new section
function createSection(id_section) {
  const new_number_of_sections = parseInt($(".section").length) + 1;
  const section = `
  <!-- SECTION -->
  <div class="section grid grid-cols-1 gap-3" data-id-section="${id_section}">

    <!-- SECTION NUMBER -->
    <div class="section-number p-2 w-fit text-white text-base bg-violet-700 rounded-t-md -mb-5 relative z-[3]">
      <span>Section</span>
      <span class="current-section-number">${new_number_of_sections}</span>
      <span>of</span>
      <span class="total-sections-number">${new_number_of_sections}</span>
    </div>
    <!-- END SECTION NUMBER -->

    <!-- SECTION INFORMATIONS -->
    <div class="section-info form-box relative p-7 rounded-md bg-white shadow before:content-[''] before:block before:w-full before:h-[10px] before:bg-violet-700 before:rounded-tl-md before:rounded-tr-md before:absolute before:left-0 before:top-0 before:z-[2]">
      <div class="mb-2 flex items-center gap-5">
        <div class="grow">
          <input type="text" class="section-title w-full pb-3 text-3xl border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Title" value="Section without a title">
        </div>
        <div class="shrink-0 relative">
          <button type="button" class="open-options-section w-[50px] aspect-square rounded-full flex justify-center items-center text-2xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
              <g fill="currentColor">
                <circle cx="10" cy="15" r="2" />
                <circle cx="10" cy="10" r="2" />
                <circle cx="10" cy="5" r="2" />
              </g>
            </svg>
          </button>
          <div class="options-section hidden absolute z-[99] left-[unset] md:left-0 right-0 md:right-[unset] top-[50px] w-[150px] h-fit bg-white border rounded shadow">
            <ul>
              <li class="hover:bg-gray-100">
                <button type="button" class="open-remove-section-modal w-full p-3 flex items-center gap-3">
                  Remove
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div>
        <textarea class="section-description w-full border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Description"></textarea>
      </div>
    </div>
    <!-- END SECTION INFORMATIONS -->

  </div>
  <!-- END SECTION -->
  `;
  return section;
}

//Update the box with the numbers of the sections
function updateSectionsNumber() {
  const sections = $(".section");
  const total_sections = sections.length;

  $(".total-sections-number").text(total_sections);

  for (let i = 0; i < total_sections; i++) {
    let section = $(sections[i]);
    let number_section = i + 1;
    $(section).find(".current-section-number").text(number_section);
  }
}

//Update the question's answer into the database
function updateQuestionAnswer(question) {
  //Getting all question's options value
  const id_question = $(question).attr("data-id-question");
  const options_value_el = $(question).find(".option-value");
  const options_value = [];

  for (let i = 0; i < options_value_el.length; i++) {
    let option_value = $(options_value_el[i]).val();
    options_value.push(option_value);
  }

  //Updating the question answer into the database
  $.ajax({
    type: "POST",
    url: "php/update_question_answer.php",
    data: {
      id_question: id_question,
      answer_question: JSON.stringify(options_value),
    },
    success: function (response) {
      if (response != true) {
        Toastify({
          text: "Error: update question answer",
          duration: 6000,
          className: "bg-red-500 rounded",
          gravity: "bottom",
          position: "left",
        }).showToast();
      }
    },
  });
}

//Update the section's order of the questions
function updateSectionOrderQuestions(section) {
  const id_section = $(section).attr("data-id-section");
  const questions = $(section).find(".question");
  const ids_questions = [];

  for (let i = 0; i < questions.length; i++) {
    let id_question = $(questions[i]).attr("data-id-question");
    ids_questions.push(id_question);
  }

  $.ajax({
    type: "POST",
    url: "php/reorder_questions.php",
    data: {
      ids_questions: JSON.stringify(ids_questions),
      id_section: id_section,
    },
    success: function (response) {},
  });
}

//Get the element where I want to drop the question
function getDragAfterElement(section, y) {
  const draggable_elements = [...$(section).find(".question:not(.dragging)")];
  return draggable_elements.reduce(
    (closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      if (offset < 0 && offset > closest.offset) {
        return { offset: offset, element: child };
      } else {
        return closest;
      }
    },
    {
      offset: Number.NEGATIVE_INFINITY,
    }
  ).element;
}
