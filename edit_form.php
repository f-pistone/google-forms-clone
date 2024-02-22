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

//Sections
$sqlGetSections = "SELECT * FROM sections WHERE id_form = $id_form";
$queryGetSections = mysqli_query($conn, $sqlGetSections) or die("Error: get sections");

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
      <input type="text" id="header_title_form" class="w-full md:w-[400px] text-lg transition focus:outline-none focus:border-b-2 focus:border-black" value="<?= $title_form_html ?>">
    </div>
    <div class="shrink-0 order-2 md:order-3 ml-auto md:ml-0 flex items-center gap-3">
      <div>
        <button type="button" class="w-[50px] aspect-square rounded-full flex justify-center items-center text-2xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
            <path fill="currentColor" d="M245.48 125.57c-.34-.78-8.66-19.23-27.24-37.81C201 70.54 171.38 50 128 50S55 70.54 37.76 87.76c-18.58 18.58-26.9 37-27.24 37.81a6 6 0 0 0 0 4.88c.34.77 8.66 19.22 27.24 37.8C55 185.47 84.62 206 128 206s73-20.53 90.24-37.75c18.58-18.58 26.9-37 27.24-37.8a6 6 0 0 0 0-4.88M128 194c-31.38 0-58.78-11.42-81.45-33.93A134.77 134.77 0 0 1 22.69 128a134.56 134.56 0 0 1 23.86-32.06C69.22 73.42 96.62 62 128 62s58.78 11.42 81.45 33.94A134.56 134.56 0 0 1 233.31 128C226.94 140.21 195 194 128 194m0-112a46 46 0 1 0 46 46a46.06 46.06 0 0 0-46-46m0 80a34 34 0 1 1 34-34a34 34 0 0 1-34 34" />
          </svg>
        </button>
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
      <div id="form" class="relative">

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
              <button type="button" class="p-2 aspect-square rounded-full flex justify-center items-center text-xl text-gray-600 transition hover:bg-gray-100 focus:bg-gray-200" title="Add section">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 56 56">
                  <path fill="currentColor" d="M8.066 26.066h39.867c3.587 0 5.391-1.757 5.391-5.367v-8.953c0-3.586-1.804-5.32-5.39-5.32H8.065c-3.586 0-5.39 1.734-5.39 5.32V20.7c0 3.61 1.804 5.367 5.39 5.367m.282-3.539c-1.383 0-2.133-.726-2.133-2.18v-8.202c0-1.477.75-2.18 2.133-2.18h39.304c1.383 0 2.133.703 2.133 2.18v8.203c0 1.453-.75 2.18-2.133 2.18Zm-.282 27.047h39.867c3.587 0 5.391-1.734 5.391-5.343v-8.977c0-3.563-1.804-5.32-5.39-5.32H8.065c-3.586 0-5.39 1.757-5.39 5.32v8.977c0 3.609 1.804 5.343 5.39 5.343m.282-3.539c-1.383 0-2.133-.726-2.133-2.18v-8.203c0-1.476.75-2.18 2.133-2.18h39.304c1.383 0 2.133.704 2.133 2.18v8.203c0 1.454-.75 2.18-2.133 2.18Z" />
                </svg>
              </button>
            </li>
          </ul>
        </menu>
        <!-- END MENU -->

        <?php
        while ($rowGetSections = mysqli_fetch_assoc($queryGetSections)) {
          $title_section = $rowGetSections['title_section'];
          $title_section_html = htmlspecialchars($title_section, ENT_QUOTES);
          $description_section = $rowGetSections['description_section'];
        ?>

          <!-- SECTION -->
          <div class="section grid grid-cols-1 gap-3">

            <!-- SECTION INFORMATIONS -->
            <div class="section-info form-box active-form-box relative p-7 rounded-md bg-white shadow before:content-[''] before:block before:w-full before:h-[10px] before:bg-violet-700 before:rounded-tl-md before:rounded-tr-md before:absolute before:left-0 before:top-0 before:z-[2]">
              <div class="mb-2">
                <input type="text" class="w-full pb-3 text-3xl border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Title" value="<?= $title_section ?>">
              </div>
              <div>
                <textarea class="w-full border-b focus:outline-none focus:border-b-2 focus:border-violet-800 transition" placeholder="Description"><?= $description_section ?></textarea>
              </div>
            </div>
            <!-- END SECTION INFORMATIONS -->

            
          </div>
          <!-- END SECTION -->

        <?php
        }
        ?>

      </div>
      <!-- FORM -->
    </div>
  </main>
  <!-- END MAIN -->

  <!-- JS -->
  <script src="./js/pages/edit_form.js"></script>
  <!-- END JS -->

</body>

</html>