$(document).ready(function () {
  document.title = $("#header_title_form").val();

  //Button to open the options menu of the form
  $(".open-options-menu").on("click", function () {
    const options_menu_to_open = $(this).next(".options-menu");
    if ($(options_menu_to_open).hasClass("hidden")) {
      $(options_menu_to_open).removeClass("hidden");
    } else {
      $(options_menu_to_open).addClass("hidden");
    }
  });

  //Button to add a new question
  $("#add_question_button").on("click", function () {
    const last_question = $(".question").last();
    const new_question = createQuestion();

    if (last_question.length > 0) {
      $(last_question).after(new_question);
    } else {
      $(".section").first().find(".section-info").after(new_question);
    }
  });

  //Toggle the active class for the form boxes
  $("#form").on("click", ".form-box", function () {
    $(".form-box").removeClass("active-form-box");
    $(this).addClass("active-form-box");
  });

  //Change of the question's type
  $("#form").on("change", ".type-question", function () {
    const question = $(this).parents(".question");
    const new_type_question = $(this).val();
    let new_question_body = "";

    if (new_type_question == "SHORT_ANSWER") {
      new_question_body = createBodyShortAnswerQuestion();
      $(question).find(".question-body").html(new_question_body);
      return;
    }

    if (new_type_question == "LONG_ANSWER") {
      new_question_body = createBodyLongAnswerQuestion();
      $(question).find(".question-body").html(new_question_body);
      return;
    }

    if (new_type_question == "MULTIPLE_CHOISE") {
      new_question_body = createBodyMultipleChoiseAnswerQuestion();
      $(question).find(".question-body").html(new_question_body);
      return;
    }

    if (new_type_question == "CHECKBOX") {
      new_question_body = createBodyCheckboxAnswerQuestion();
      $(question).find(".question-body").html(new_question_body);
      return;
    }

    if (new_type_question == "LIST") {
      new_question_body = createBodyListAnswerQuestion();
      $(question).find(".question-body").html(new_question_body);
      return;
    }
  });

  //Button to duplicate a question
  $("#form").on("click", ".duplicate-question-button", function () {
    const question = $(this).parents(".question");
    const type_question_value = $(question).find(".type-question").val();
    const question_clone = $(question).clone();
    $(question_clone).find(".type-question").val(type_question_value);
    $(question).after(question_clone);
  });

  //Button to remove a question
  $("#form").on("click", ".remove-question-button", function () {
    $(this).parents(".question").remove();
    Toastify({
      text: "Element removed",
      duration: 6000,
      className: "bg-zinc-800 rounded",
      gravity: "bottom",
      position: "left",
    }).showToast();
  });

  //Button to add a new option for the question
  $("#form").on("click", ".add-option-button", function () {
    const question = $(this).parents(".question");
    const type_question = $(question).find(".type-question").val();
    const add_options_menu = $(question).find(".add-options-menu");

    if (type_question == "MULTIPLE_CHOISE") {
      const option = createOptionMultipleChoiseAnswerQuestion();
      $(add_options_menu).before(option);
      return;
    }

    if (type_question == "CHECKBOX") {
      const option = createOptionCheckboxAnswerQuestion();
      $(add_options_menu).before(option);
      return;
    }

    if (type_question == "LIST") {
      const option = createOptionListAnswerQuestion();
      $(add_options_menu).before(option);
      return;
    }
  });
});

//Create a new question
function createQuestion() {
  const new_question = `            
  <!-- QUESTION SHORT ANSWER -->
  <div class="question form-box relative p-7 rounded-md bg-white shadow flex flex-col gap-4">

    <!-- QUESTION HEADER -->
    <div class="question-header flex flex-wrap justify-start md:justify-between items-center gap-5">
      <div class="basis-full md:basis-6/12">
        <input type="text" class="p-4 w-full bg-gray-100 border-b border-gray-500 focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Question" value="">
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
        <input class="switch" type="checkbox">
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
    <li class="h-[40px] flex items-center gap-3">
      <div class="shrink-0 text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
        </svg>
      </div>
      <div class="grow">
        <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
        <button type="button" class="p-1 rounded text-blue-500 hover:bg-blue-100">
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
    <li class="h-[40px] flex items-center gap-3">
      <div class="shrink-0 text-xl text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
          <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
        </svg>
      </div>
      <div class="grow">
        <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
        <button type="button" class="p-1 rounded text-blue-500 hover:bg-blue-100">
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
    <li class="pl-1">
      <div class="h-[40px] flex items-center gap-3">
        <div class="grow">
          <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
        </div>
        <div class="shrink-0">
          <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
  <li class="h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
    </div>
    <div class="shrink-0">
      <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
  <li class="h-[40px] flex items-center gap-3">
    <div class="shrink-0 text-xl text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
        <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
      </svg>
    </div>
    <div class="grow">
      <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
    </div>
    <div class="shrink-0">
      <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
  <li class="pl-1">
    <div class="h-[40px] flex items-center gap-3">
      <div class="grow">
        <input type="text" class="w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="Option">
      </div>
      <div class="shrink-0">
        <button type="button" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
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
