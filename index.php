<?php
include_once("./database/conn.php");
session_start();
if (empty($_SESSION['id_user'])) {
  header("Location: login.php");
}
$id_user = (int)$_SESSION['id_user'];

$sqlGetUser = "SELECT first_name_user, email_user FROM users WHERE id_user = $id_user";
$queryGetUser = mysqli_query($conn, $sqlGetUser) or die("Error: get user");
while ($rowGetUser = mysqli_fetch_assoc($queryGetUser)) {
  $first_name_user = $rowGetUser['first_name_user'];
  $email_user = $rowGetUser['email_user'];
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <!-- HEADER -->
  <header class="h-[65px] p-4 flex justify-between items-center gap-12 border-b">
    <div class="flex items-center gap-2">
      <div class="shrink-0">
        <img src="./assets/images/google-forms-logo.svg" class="w-[40px] aspect-square" alt="Logo">
      </div>
      <div class="text-center">
        <h1 class="text-2xl text-gray-600">Forms</h1>
      </div>
    </div>
    <div class="grow flex">
      <input type="text" id="search_forms" class="p-3 w-full rounded bg-gray-100 focus:outline-none focus:border focus:bg-white focus:shadow" placeholder="Search" value="">
    </div>
    <div class="shrink-0 relative">
      <button type="button" class="w-[50px] aspect-square rounded-full p-1 hover:bg-gray-100 focus:bg-gray-200" id="open_profile_box_button">
        <img class="w-full h-full rounded-full object-contain" src="./assets/images/user-image-placeholder.png" alt="Profile Image">
      </button>
      <!-- PROFILE BOX -->
      <div id="profile-box" class="hidden absolute z-[9999] right-0 w-screen md:w-[435px] h-[385px] p-4 bg-slate-100 border rounded-lg shadow-lg flex flex-col items-center gap-5">
        <div class="flex items-center gap-2">
          <span class="text-center break-all"><?= $email_user ?></span>
        </div>
        <div class="h-full flex flex-col items-center gap-3">
          <div>
            <img class="w-[80px] aspect-square rounded-full object-contain" src="./assets/images/user-image-placeholder.png" alt="Profile Image">
          </div>
          <div>
            <h2 class="text-2xl text-center break-all">Hi <?= $first_name_user ?></h2>
          </div>
          <div>
            <a href="./user_settings.php" target="_blank" class="inline-block px-7 py-2 text-blue-500 border border-gray-600 rounded-full hover:bg-blue-100">
              Manage your account
            </a>
          </div>
          <div class="mt-auto">
            <a href="./logout.php" class="flex items-center gap-1 hover:underline">
              <span class="text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M19.285 12h-8.012m5.237 3.636L20 12l-3.49-3.636M13.455 7V4H4v16h9.455v-3" />
                </svg>
              </span>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </div>
      <!-- END PROFILE BOX -->
    </div>
  </header>
  <!-- END HEADER -->

  <!-- MAIN -->
  <main>

    <!-- CREATE FORM -->
    <section class="bg-gray-100">
      <div class="my-container p-2">
        <h1 class="px-1 py-3 text-lg">Create a new form</h1>
        <div class="flex gap-5">
          <!-- EMPTY FORM -->
          <div id="create_new_form_button" class="w-[165px]">
            <div class="cursor-pointer">
              <img src="./assets/images/empty-form-plus.png" class="w-full border rounded hover:border-purple-500" alt="Empty Form">
            </div>
            <div class="py-2">
              <h3 class="text-sm font-medium">Empty Form</h3>
            </div>
          </div>
          <!-- END EMPTY FORM -->
        </div>
      </div>
    </section>
    <!-- END CREATE FORM -->

    <!-- FORMS -->
    <div class="my-container p-2">
      <h1 class="py-3 text-lg font-medium">Forms</h1>

      <!-- LIST OF FORMS -->
      <ul id="forms_list" class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <?php
        $sqlGetForms = "SELECT * FROM forms WHERE id_user = $id_user ORDER BY updated_at DESC";
        $queryGetForms = mysqli_query($conn, $sqlGetForms) or die("Error: get user's forms");
        while ($rowGetForms = mysqli_fetch_assoc($queryGetForms)) {
          $id_form = (int)$rowGetForms['id_form'];
          $title_form = $rowGetForms['title_form'];
          $title_form_html = htmlspecialchars($title_form, ENT_QUOTES);
          $image_form = $rowGetForms['image_form'];
          $updated_at = $rowGetForms['updated_at'];

          if (strlen($title_form) > 20) {
            $title_form = substr_replace($title_form, "...", 20);
          }
        ?>
          <li>
            <!-- FORM -->
            <div class="form w-full cursor-pointer border rounded hover:border-purple-500" data-id-form="<?= $id_form ?>" data-title-form="<?= $title_form_html ?>">
              <div class="border-b">
                <img class="w-full rounded-t" src="<?= $image_form ?>" alt="<?= $title_form_html ?>">
              </div>
              <div class="p-3">
                <h4 class="title-form break-all font-medium mb-2"><?= $title_form ?></h4>
                <div class="flex items-center gap-2">
                  <div>
                    <img src="./assets/images/google-forms-logo.svg" class="w-[20px] aspect-square" alt="Form Icon">
                  </div>
                  <div>
                    <span class="text-xs text-gray-600">
                      <?= date("d/m/Y H:i", strtotime($updated_at)) ?>
                    </span>
                  </div>
                  <div class="ml-auto relative">
                    <button type="button" class="open-options-menu flex justify-center items-center w-[30px] aspect-square text-xl text-gray-600 rounded-full hover:bg-gray-100">
                      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                        <g fill="currentColor">
                          <circle cx="10" cy="15" r="2" />
                          <circle cx="10" cy="10" r="2" />
                          <circle cx="10" cy="5" r="2" />
                        </g>
                      </svg>
                    </button>
                    <!-- OPTIONS MENU -->
                    <div class="options-menu hidden absolute z-[9999] right-0 md:right-auto left-auto md:left-0 bottom-[30px] md:-translate-x-1/2 w-[250px] h-fit bg-white border rounded shadow">
                      <ul>
                        <li class="hover:bg-gray-100">
                          <button type="button" class="open-rename-form-modal w-full p-3 flex items-center gap-3">
                            <span class="text-lg font-bold">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="4" d="M4 8h28m-4 13h16M18 42V8m18 34V21" />
                              </svg>
                            </span>
                            <span>Rename</span>
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
                        <li class="hover:bg-gray-100">
                          <a class="w-full p-3 flex items-center gap-3" href="./edit_form.php?id_form=<?= $id_form ?>" target="_blank">
                            <span class="text-lg font-bold">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 2048 2048">
                                <path fill="currentColor" d="M2048 0v1664h-384v384H0V384h384V0zm-128 1536V128H512v256h256v128H128v1408h1408v-640h128v256zm-979-339l-90-90l594-595h-421V384h640v640h-128V603z" />
                              </svg>
                            </span>
                            <span>Open in a new tab</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <!-- END OPTIONS MENU -->
                  </div>
                </div>
              </div>
            </div>
            <!-- END FORM -->
          </li>
        <?php
        }
        ?>
      </ul>
      <!-- END LIST OF FORMS -->

    </div>
    <!-- END FORMS -->

  </main>
  <!-- END MAIN -->

  <!-- RENAME FORM MODAL -->
  <dialog id="rename_form_modal" class="modal p-5 w-[400px] rounded-lg shadow">
    <div class="mb-5">
      <h2 class="text-2xl mb-2">Rename</h2>
      <h3 class="text-gray-600">Insert a new name for the element:</h3>
    </div>
    <div class="mb-5">
      <input type="text" id="new_title_form" class="w-full px-2 py-1 text-sm border rounded hover:border-black focus:border-purple-500 focus:outline-none" value="">
      <input type="hidden" id="id_form_to_rename" value="">
    </div>
    <div class="flex flex-wrap justify-end items-center gap-2">
      <button type="button" id="close_rename_form_modal" class="px-10 py-1 text-purple-500 border rounded hover:bg-gray-100 hover:text-black">
        Back
      </button>
      <button type="button" id="rename_form_button" class="px-8 py-1 text-white rounded bg-purple-500 hover:bg-blue-500">
        OK
      </button>
    </div>
  </dialog>
  <!-- END RENAME FORM MODAL -->

  <!-- REMOVE FORM MODAL -->
  <dialog id="remove_form_modal" class="modal p-5 w-[800px] rounded-lg shadow">
    <div class="mb-5">
      <h2 class="text-2xl mb-2">Remove this element?</h2>
      <h3 class="text-gray-600">The element "<span id="remove_title_form"></span>" will be removed.</h3>
      <input type="hidden" id="id_form_to_remove" value="">
    </div>
    <div class="flex flex-wrap justify-end items-center gap-2">
      <button type="button" id="close_remove_form_modal" class="px-10 py-1 text-purple-500 border rounded hover:bg-gray-100 hover:text-black">
        Back
      </button>
      <button type="button" id="remove_form_button" class="px-8 py-1 text-white rounded bg-purple-500 hover:bg-blue-500">
        REMOVE
      </button>
    </div>
  </dialog>
  <!-- END REMOVE FORM MODAL -->

  <!-- JS -->
  <script src="./js/pages/index.js"></script>
  <!-- END JS -->
</body>

</html>