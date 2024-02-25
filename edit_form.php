<?php
include_once("./database/conn.php");

session_start();
if (empty($_SESSION['id_user'])) {
  header("Location: login.php");
}

$id_user = (int)$_SESSION['id_user'];
$id_form = (int)$_GET['id_form'];

$sqlCheckIfUserOwnsForm = "SELECT id_form, id_user FROM forms WHERE id_form = $id_form AND id_user = $id_user";
$queryCheckIfUserOwnsForm = mysqli_query($conn, $sqlCheckIfUserOwnsForm) or die("Error: check if user owns form");
$user_owns_form = (int)mysqli_num_rows($queryCheckIfUserOwnsForm);
if ($user_owns_form === 0) {
  header("Location: index.php");
}

//Form informations
$sqlGetForm = "SELECT * FROM forms WHERE id_form = $id_form";
$queryGetForm = mysqli_query($conn, $sqlGetForm) or die("Error: get form");
while ($rowGetForm = mysqli_fetch_assoc($queryGetForm)) {
  $title_form = $rowGetForm['title_form'];
  $title_form_html = htmlspecialchars($title_form, ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body class="bg-purple-100">
  <!-- HEADER -->
  <header class="fixed z-[999] bg-white w-full py-2 px-5 flex flex-wrap items-center gap-3 border-b">
    <a href="./index.php" class="shrink-0 order-1 block">
      <img src="./assets/images/google-forms-logo.svg" class="w-[40px] aspect-square" alt="Logo">
    </a>
    <div class="grow order-3 md:order-2">
      <input type="text" id="header_title_form" class="w-full md:w-[400px] text-lg transition focus:outline-none focus:border-b-2 focus:border-black" value="<?= $title_form_html ?>" data-current-title-form="<?= $title_form_html ?>">
    </div>
    <div class="shrink-0 order-2 md:order-3 ml-auto md:ml-0 flex items-center gap-3">
      <div>
        <a href="./preview_form.php?id_form=<?= $id_form ?>" target="_blank" class="w-[50px] aspect-square rounded-full flex justify-center items-center text-2xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
            <path fill="currentColor" d="M245.48 125.57c-.34-.78-8.66-19.23-27.24-37.81C201 70.54 171.38 50 128 50S55 70.54 37.76 87.76c-18.58 18.58-26.9 37-27.24 37.81a6 6 0 0 0 0 4.88c.34.77 8.66 19.22 27.24 37.8C55 185.47 84.62 206 128 206s73-20.53 90.24-37.75c18.58-18.58 26.9-37 27.24-37.8a6 6 0 0 0 0-4.88M128 194c-31.38 0-58.78-11.42-81.45-33.93A134.77 134.77 0 0 1 22.69 128a134.56 134.56 0 0 1 23.86-32.06C69.22 73.42 96.62 62 128 62s58.78 11.42 81.45 33.94A134.56 134.56 0 0 1 233.31 128C226.94 140.21 195 194 128 194m0-112a46 46 0 1 0 46 46a46.06 46.06 0 0 0-46-46m0 80a34 34 0 1 1 34-34a34 34 0 0 1-34 34" />
          </svg>
        </a>
      </div>
      <div>
        <button type="button" class="px-5 py-1 text-white rounded bg-violet-800 hover:bg-violet-700 shadow">
          Send
        </button>
      </div>
      <div class="relative">
        <button type="button" class="open-options-menu w-[50px] aspect-square rounded-full flex justify-center items-center text-2xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
            <g fill="currentColor">
              <circle cx="10" cy="15" r="2" />
              <circle cx="10" cy="10" r="2" />
              <circle cx="10" cy="5" r="2" />
            </g>
          </svg>
        </button>
        <div class="options-menu hidden absolute z-[999] right-0 top-[50px] w-[250px] h-fit bg-white border rounded shadow">
          <ul>
            <li class="hover:bg-gray-100">
              <button type="button" class="open-duplicate-form-modal w-full p-3 flex items-center gap-3">
                <span class="text-lg font-bold">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                    <path fill="currentColor" fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
                  </svg>
                </span>
                <span>Duplicate</span>
              </button>
            </li>
            <li class="hover:bg-gray-100">
              <button type="button" class="open-remove-form-modal w-full p-3 flex items-center gap-3">
                <span class="text-lg font-bold">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" />
                    <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" />
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224l8 224m136-224l-8 224" />
                  </svg>
                </span>
                <span>Remove</span>
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div>
        <img class="w-[40px] aspect-square rounded-full object-contain" src="https://lh3.googleusercontent.com/-t8idYWqDDbg/AAAAAAAAAAI/AAAAAAAAAAA/ALKGfklvc8tPxaawNFNx_MuXusN0UiODZQ/photo.jpg" alt="Profile Image">
      </div>
    </div>
  </header>
  <!-- END HEADER -->

  <!-- MAIN -->
  <main class="pt-[120px] md:pt-[80px] pb-10 px-1 relative">
    <div class="max-w-[800px] mx-auto my-0">
      <!-- FORM -->
      <div id="form" class="relative grid grid-cols-1 gap-10" data-id-form="<?= $id_form ?>">

        <!-- MENU -->
        <menu class="menu w-full md:w-[50px] px-2 md:px-0 py-5 md:py-2 border rounded bg-white shadow-xl fixed left-0 bottom-0 md:left-[unset] md:bottom-[unset] md:right-0 z-[999]">
          <ul class="flex flex-row md:flex-col justify-center md:justify-start items-center gap-2">
            <li>
              <button type="button" id="add_question_button" class="p-2 aspect-square rounded-full flex justify-center items-center text-xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200" title="Add question">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024">
                  <path fill="currentColor" d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01M736 480H544V288c0-17.664-14.336-32-32-32s-32 14.336-32 32v192H288c-17.664 0-32 14.336-32 32s14.336 32 32 32h192v192c0 17.664 14.336 32 32 32s32-14.336 32-32V544h192c17.664 0 32-14.336 32-32s-14.336-32-32-32" />
                </svg>
              </button>
            </li>
            <li>
              <button type="button" id="add_section_button" class="p-2 aspect-square rounded-full flex justify-center items-center text-xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200" title="Add section">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 56 56">
                  <path fill="currentColor" d="M8.066 26.066h39.867c3.587 0 5.391-1.757 5.391-5.367v-8.953c0-3.586-1.804-5.32-5.39-5.32H8.065c-3.586 0-5.39 1.734-5.39 5.32V20.7c0 3.61 1.804 5.367 5.39 5.367m.282-3.539c-1.383 0-2.133-.726-2.133-2.18v-8.202c0-1.477.75-2.18 2.133-2.18h39.304c1.383 0 2.133.703 2.133 2.18v8.203c0 1.453-.75 2.18-2.133 2.18Zm-.282 27.047h39.867c3.587 0 5.391-1.734 5.391-5.343v-8.977c0-3.563-1.804-5.32-5.39-5.32H8.065c-3.586 0-5.39 1.757-5.39 5.32v8.977c0 3.609 1.804 5.343 5.39 5.343m.282-3.539c-1.383 0-2.133-.726-2.133-2.18v-8.203c0-1.476.75-2.18 2.133-2.18h39.304c1.383 0 2.133.704 2.133 2.18v8.203c0 1.454-.75 2.18-2.133 2.18Z" />
                </svg>
              </button>
            </li>
          </ul>
        </menu>
        <!-- END MENU -->

        <?php

        //Sections
        $sqlGetSections = "SELECT * FROM sections WHERE id_form = $id_form ORDER BY order_section";
        $queryGetSections = mysqli_query($conn, $sqlGetSections) or die("Error: get sections");
        $total_sections_number = (int)mysqli_num_rows($queryGetSections);
        $index = 0;
        while ($rowGetSections = mysqli_fetch_assoc($queryGetSections)) {
          $id_section = (int)$rowGetSections['id_section'];
          $title_section = $rowGetSections['title_section'];
          $title_section_html = htmlspecialchars($title_section, ENT_QUOTES);
          $description_section = $rowGetSections['description_section'];
        ?>

          <!-- SECTION -->
          <div class="section grid grid-cols-1 gap-3" data-id-section="<?= $id_section ?>">

            <!-- SECTION NUMBER -->
            <div class="section-number p-2 w-fit text-white text-base bg-violet-700 rounded-t-md -mb-5 relative z-[3]">
              <span>Section</span>
              <span class="current-section-number"><?= $index + 1 ?></span>
              <span>of</span>
              <span class="total-sections-number"><?= $total_sections_number ?></span>
            </div>
            <!-- END SECTION NUMBER -->

            <!-- SECTION INFORMATIONS -->
            <div class="section-info form-box active-form-box relative p-7 rounded-md bg-white shadow before:content-[''] before:block before:w-full before:h-[10px] before:bg-violet-700 before:rounded-tl-md before:rounded-tr-md before:absolute before:left-0 before:top-0 before:z-[2]">
              <div class="mb-2 flex items-center gap-5">
                <div class="grow">
                  <input type="text" class="section-title w-full pb-3 text-3xl border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Title" value="<?= $title_section ?>">
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
                <textarea class="section-description w-full border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Description"><?= $description_section ?></textarea>
              </div>
            </div>
            <!-- END SECTION INFORMATIONS -->

            <?php

            //Questions
            $sqlGetQuestions = "SELECT * FROM questions WHERE id_section = $id_section ORDER BY order_question ASC";
            $queryGetQuestions = mysqli_query($conn, $sqlGetQuestions) or die("Error: get questions");
            while ($rowGetQuestions = mysqli_fetch_assoc($queryGetQuestions)) {

              $id_question = (int)$rowGetQuestions['id_question'];
              $name_question = $rowGetQuestions['name_question'];
              $name_question_html = htmlspecialchars($name_question, ENT_QUOTES);
              $type_question = $rowGetQuestions['type_question'];
              $answer_question = explode(" | ", $rowGetQuestions['answer_question']);
              $required_question = ((int)$rowGetQuestions['required_question'] === 1) ? "checked" : "";

              $add_other_button_hidden = "";
              if (in_array("Other", $answer_question)) {
                $add_other_button_hidden = "hidden";
              }

              $short_answer_selected = "";
              $long_answer_selected = "";
              $multiple_choise_selected = "";
              $checkbox_selected = "";
              $list_selected = "";
              switch ($type_question) {
                case "SHORT_ANSWER":
                  $short_answer_selected = "selected";
                  break;
                case "LONG_ANSWER":
                  $long_answer_selected = "selected";
                  break;
                case "MULTIPLE_CHOISE":
                  $multiple_choise_selected = "selected";
                  break;
                case "CHECKBOX":
                  $checkbox_selected = "selected";
                  break;
                case "LIST":
                  $list_selected = "selected";
                  break;
                default:
                  break;
              }
            ?>
              <!-- QUESTION -->
              <div class="question form-box relative p-7 rounded-md bg-white shadow flex flex-col gap-4" draggable="true" data-id-question="<?= $id_question ?>">
                <!-- QUESTION HEADER -->
                <div class="question-header flex flex-wrap justify-start md:justify-between items-center gap-5">
                  <div class="basis-full md:basis-6/12">
                    <input type="text" class="question-name p-4 w-full bg-gray-100 border-b border-gray-500 focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Question" value="<?= $name_question_html ?>">
                  </div>
                  <div class="basis-full md:basis-5/12">
                    <select class="type-question p-4 w-full cursor-pointer border rounded focus:outline-none">
                      <option value="SHORT_ANSWER" <?= $short_answer_selected ?>>Short answer</option>
                      <option value="LONG_ANSWER" <?= $long_answer_selected ?>>Long answer</option>
                      <option value="MULTIPLE_CHOISE" <?= $multiple_choise_selected ?>>Multiple choise</option>
                      <option value="CHECKBOX" <?= $checkbox_selected ?>>Checkbox</option>
                      <option value="LIST" <?= $list_selected ?>>List</option>
                    </select>
                  </div>
                </div>
                <!-- END QUESTION HEADER -->

                <?php
                if ($type_question == "SHORT_ANSWER") {
                ?>
                  <!-- QUESTION BODY -->
                  <div class="question-body mb-10">
                    <p class="border-dotted border-b border-gray-500 text-gray-500">Short answer</p>
                  </div>
                  <!-- END QUESTION BODY -->
                <?php
                }
                ?>

                <?php
                if ($type_question == "LONG_ANSWER") {
                ?>
                  <!-- QUESTION BODY -->
                  <div class="question-body mb-10">
                    <p class="border-dotted border-b border-gray-500 text-gray-500">Long answer</p>
                  </div>
                  <!-- END QUESTION BODY -->
                <?php
                }
                ?>

                <?php
                if ($type_question == "MULTIPLE_CHOISE") {
                ?>
                  <!-- QUESTION BODY -->
                  <div class="question-body mb-10">
                    <ul class="flex flex-col gap-1">
                      <?php
                      foreach ($answer_question as $answer) {
                        $answer = htmlspecialchars($answer, ENT_QUOTES);
                        if (trim($answer) != "Other") {
                      ?>
                          <!-- OPTION -->
                          <li class="option h-[40px] flex items-center gap-3">
                            <div class="shrink-0 text-xl text-gray-400">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 1 18 0a9 9 0 0 1-18 0" />
                              </svg>
                            </div>
                            <div class="grow">
                              <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="<?= $answer ?>">
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
                        <?php
                        } else {
                        ?>
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
                      <?php
                        }
                      }
                      ?>
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
                          <span class="<?= $add_other_button_hidden ?>">or</span>
                          <button type="button" class="add-other-option-button <?= $add_other_button_hidden ?> p-1 rounded text-blue-500 hover:bg-blue-100">
                            add "Other"
                          </button>
                        </div>
                      </li>
                      <!-- END ADD OPTIONS MENU -->
                    </ul>
                  </div>
                  <!-- END QUESTION BODY -->
                <?php
                }
                ?>

                <?php
                if ($type_question == "CHECKBOX") {
                ?>
                  <!-- QUESTION BODY -->
                  <div class="question-body mb-10">
                    <ul class="flex flex-col gap-1">
                      <?php
                      foreach ($answer_question as $answer) {
                        $answer = htmlspecialchars($answer, ENT_QUOTES);
                        if (trim($answer) != "Other") {
                      ?>
                          <!-- OPTION -->
                          <li class="option h-[40px] flex items-center gap-3">
                            <div class="shrink-0 text-xl text-gray-400">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                                <path fill="currentColor" d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2M6 26V6h20v20Z" />
                              </svg>
                            </div>
                            <div class="grow">
                              <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="<?= $answer ?>">
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
                        <?php
                        } else {
                        ?>
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
                      <?php
                        }
                      }
                      ?>
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
                          <span class="<?= $add_other_button_hidden ?>">or</span>
                          <button type="button" class="add-other-option-button <?= $add_other_button_hidden ?> p-1 rounded text-blue-500 hover:bg-blue-100">
                            add "Other"
                          </button>
                        </div>
                      </li>
                      <!-- END ADD OPTIONS MENU -->
                    </ul>
                  </div>
                  <!-- END QUESTION BODY -->
                <?php
                }
                ?>

                <?php
                if ($type_question == "LIST") {
                ?>
                  <!-- QUESTION BODY -->
                  <div class="question-body mb-10">
                    <ol class="list-decimal pl-4 flex flex-col gap-1">
                      <?php
                      foreach ($answer_question as $answer) {
                        $answer = htmlspecialchars($answer, ENT_QUOTES);
                      ?>
                        <!-- OPTION -->
                        <li class="option pl-1">
                          <div class="h-[40px] flex items-center gap-3">
                            <div class="grow">
                              <input type="text" class="option-value w-full focus:outline-none focus:border-b-2 focus:border-violet-800 hover:border-b" placeholder="Option" value="<?= $answer ?>">
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
                      <?php
                      }
                      ?>
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
                  </div>
                  <!-- END QUESTION BODY -->
                <?php
                }
                ?>

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
                    <input class="question-required switch" type="checkbox" value="1" <?= $required_question ?>>
                  </div>
                </div>
                <!-- END QUESTION FOOTER -->
              </div>
              <!-- END QUESTION -->
            <?php
            }
            ?>
          </div>
          <!-- END SECTION -->

        <?php
          $index++;
        }
        ?>
      </div>
      <!-- FORM -->
    </div>
  </main>
  <!-- END MAIN -->

  <!-- REMOVE SECTION MODAL -->
  <dialog id="remove_section_modal" class="modal p-5 w-[400px] rounded shadow">
    <div class="mb-5">
      <h2 class="text-xl font-medium mb-2">Delete the questions and the section?</h2>
      <h3 class="text-gray-800">
        If you delete a section, the questions and the answers that it contains will be deleted too.
      </h3>
      <input type="hidden" id="id_section_to_remove" value="">
    </div>
    <div class="flex flex-wrap justify-end items-center gap-2">
      <button type="button" id="close_remove_section_modal" class="px-5 py-2 text-black font-medium rounded focus:bg-gray-200">
        BACK
      </button>
      <button type="button" id="remove_section_button" class="px-5 py-2 text-blue-500 font-medium rounded focus:bg-blue-200">
        OK
      </button>
    </div>
  </dialog>
  <!-- END REMOVE SECTION MODAL -->

  <!-- JS -->
  <script src="./js/pages/edit_form.js"></script>
  <!-- END JS -->
</body>

</html>