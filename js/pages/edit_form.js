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

  //Toggle the active class for the form boxes
  $(".form-box").on("click", function () {
    $(".form-box").removeClass("active-form-box");
    $(this).addClass("active-form-box");
  });

  //Button to add a new question
  $("#add_question_button").on("click", function () {
    const last_question = $(".question").last();
    const new_question = createQuestion();

    if (last_question.length > 0) {
      $(last_question).after(new_question);
    } else {
      $(".section").first().after(new_question);
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
        <select class="p-4 w-full cursor-pointer border rounded focus:outline-none">
          <option value="SHORT_ANSWER">Short answer</option>
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
        <button type="button" class="p-3 w-[50px] aspect-square rounded-full flex justify-center items-center text-lg transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
            <path fill="currentColor" fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
          </svg>
        </button>
        <button type="button" class="p-3 w-[50px] aspect-square rounded-full flex justify-center items-center text-lg transition hover:bg-gray-100 focus:bg-gray-200">
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
