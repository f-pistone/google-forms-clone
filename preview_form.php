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

  <main class="px-1 py-5">
    <div class="max-w-[650px] mx-auto my-0">
      <form id="form" class="grid grid-cols-1 gap-5" data-id-form="<?= $id_form ?>">

        <!-- FORM INFORMATIONS -->
        <div class="form-info bg-white rounded-md border border-t-[10px] border-t-violet-800">
          <div class="px-7 py-3">
            <h1 class="text-3xl"><?= $title_form ?></h1>
            <input type="hidden" id="title_form" value="<?= $title_form_html ?>">
          </div>
          <div class="border-y px-7 py-5">
            <label for="email_person" class="block mb-1">Your email</label>
            <input type="email" id="email_person" class="w-full border-b-2 focus:outline-none focus:border-violet-800 transition" placeholder="Insert your email" value="" required>
          </div>
          <div class="px-7 py-3">
            <h5 class="text-red-600">* Indicates a required question</h5>
          </div>
        </div>
        <!-- END FORM INFORMATIONS -->

        <!-- SECTION -->
        <section class="section grid grid-cols-1 gap-3" data-id-section="">

          <!-- SECTION INFORMATIONS -->
          <div class="section-info bg-white rounded-md border">
            <div class="bg-violet-800 px-7 py-3 rounded-t-md text-white text-lg">
              <h2>Title</h2>
            </div>
            <div class="p-5">
              <p>Description</p>
            </div>
          </div>
          <!-- END SECTION INFORMATIONS -->

          <!-- SHORT ANSWER QUESTION -->
          <div class="question p-5 bg-white rounded-md border" data-id-question="">
            <div class="mb-5">
              <h3>Short answer <span class="text-red-500">*</span></h3>
            </div>
            <div>
              <input type="text" class="w-full md:w-1/2 border-b-2 focus:outline-none focus:border-violet-800 transition" placeholder="Your answer" value="">
            </div>
            <div class="mt-2 text-red-500 flex items-center gap-3">
              <span class="text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0a9 9 0 0 1 18 0m-9 3.75h.008v.008H12z" />
                </svg>
              </span>
              <span class="text-xs">
                This question is required
              </span>
            </div>
          </div>
          <!-- END SHORT ANSWER QUESTION -->

          <!-- LONG ANSWER QUESTION -->
          <div class="question p-5 bg-white rounded-md border" data-id-question="">
            <div class="mb-5">
              <h3>Long answer <span class="text-red-500">*</span></h3>
            </div>
            <div>
              <textarea class="w-full border-b-2 focus:outline-none focus:border-violet-800 transition" placeholder="Your answer"></textarea>
            </div>
            <div class="mt-2 text-red-500 flex items-center gap-3">
              <span class="text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0a9 9 0 0 1 18 0m-9 3.75h.008v.008H12z" />
                </svg>
              </span>
              <span class="text-xs">
                This question is required
              </span>
            </div>
          </div>
          <!-- END LONG ANSWER QUESTION -->

          <!-- MULTIPLE CHOISE QUESTION -->
          <div class="question p-5 bg-white rounded-md border" data-id-question="">
            <div class="mb-5">
              <h3>Multiple choise <span class="text-red-500">*</span></h3>
            </div>
            <div>
              <ul class="flex flex-col gap-3">
                <li>
                  <label class="flex items-center gap-2">
                    <input type="radio" class="w-[20px] h-[20px]">
                    <span>Option 1</span>
                  </label>
                </li>
                <li>
                  <label class="flex items-center gap-2">
                    <input type="radio" class="w-[20px] h-[20px]">
                    <div class="grow flex items-center gap-2">
                      <span>
                        Other:
                      </span>
                      <input type="text" class="w-full border-b-2 focus:outline-none focus:border-violet-800 transition" value="">
                    </div>
                  </label>
                </li>
              </ul>
            </div>
            <div class="mt-2 text-red-500 flex items-center gap-3">
              <span class="text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0a9 9 0 0 1 18 0m-9 3.75h.008v.008H12z" />
                </svg>
              </span>
              <span class="text-xs">
                This question is required
              </span>
            </div>
          </div>
          <!-- END MULTIPLE CHOISE QUESTION -->

          <!-- CHECKBOX QUESTION -->
          <div class="question p-5 bg-white rounded-md border" data-id-question="">
            <div class="mb-5">
              <h3>Checkbox <span class="text-red-500">*</span></h3>
            </div>
            <div>
              <ul class="flex flex-col gap-3">
                <li>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" class="w-[20px] h-[20px]">
                    <span>Option 1</span>
                  </label>
                </li>
                <li>
                  <label class="flex items-center gap-2">
                    <input type="checkbox" class="w-[20px] h-[20px]">
                    <div class="grow flex items-center gap-2">
                      <span>
                        Other:
                      </span>
                      <input type="text" class="w-full border-b-2 focus:outline-none focus:border-violet-800 transition" value="">
                    </div>
                  </label>
                </li>
              </ul>
            </div>
            <div class="mt-2 text-red-500 flex items-center gap-3">
              <span class="text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0a9 9 0 0 1 18 0m-9 3.75h.008v.008H12z" />
                </svg>
              </span>
              <span class="text-xs">
                This question is required
              </span>
            </div>
          </div>
          <!-- END CHECKBOX QUESTION -->

          <!-- LIST QUESTION -->
          <div class="question p-5 bg-white rounded-md border" data-id-question="">
            <div class="mb-5">
              <h3>List <span class="text-red-500">*</span></h3>
            </div>
            <div>
              <select class="border px-2 py-3 w-full cursor-pointer rounded focus:outline-none">
                <option class="text-gray-500" value="" selected>Choose</option>
                <option value="">Option 1</option>
              </select>
            </div>
            <div class="mt-2 text-red-500 flex items-center gap-3">
              <span class="text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0a9 9 0 0 1 18 0m-9 3.75h.008v.008H12z" />
                </svg>
              </span>
              <span class="text-xs">
                This question is required
              </span>
            </div>
          </div>
          <!-- END LIST QUESTION -->

        </section>
        <!-- END SECTION -->

        <!-- ACTIONS -->
        <div class="flex flex-wrap items-center gap-10">

          <!-- BUTTONS -->
          <div class="flex flex-wrap items-center gap-2">
            <button type="button" class="px-6 py-1 bg-white text-violet-800 border rounded hover:bg-gray-100 focus:bg-violet-200">
              Back
            </button>
            <button type="button" class="px-6 py-1 bg-white text-violet-800 border rounded hover:bg-gray-100 focus:bg-violet-200">
              Next
            </button>
            <button type="button" class="px-6 py-1 bg-violet-800 text-white border rounded hover:bg-violet-700 focus:bg-violet-400">
              Send
            </button>
          </div>
          <!-- END BUTTONS -->

          <!-- PROGRESS INFO  -->
          <div class="flex flex-wrap items-center gap-2">

            <!-- PROGRESS BAR  -->
            <div>
              <div class="rounded-md w-[185px] h-[10px] bg-gray-500">
                <div class="rounded-md w-[50px] max-w-full h-full bg-blue-500">
                </div>
              </div>
            </div>
            <!-- END PROGRESS BAR  -->

            <!-- PAGE INFO -->
            <div>
              <span>Page</span>
              <span>1</span>
              <span>of</span>
              <span>2</span>
            </div>
            <!-- END PAGE INFO -->

          </div>
          <!-- END PROGRESS INFO  -->

        </div>
        <!-- END ACTIONS -->

      </form>
    </div>

    <!-- EDIT BUTTON -->
    <div>
      <a href="./edit_form.php?id_form=<?= $id_form ?>" class="fixed right-5 bottom-5 z-[999] flex justify-center items-center bg-white text-violet-800 text-2xl w-[50px] aspect-square rounded-full shadow hover:bg-gray-100" title="Edit this form">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
          <g fill="none">
            <path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
            <path fill="currentColor" d="M16.035 3.015a3 3 0 0 1 4.099-.135l.144.135l.707.707a3 3 0 0 1 .135 4.098l-.135.144L9.773 19.177a1.5 1.5 0 0 1-.562.354l-.162.047l-4.454 1.028a1.001 1.001 0 0 1-1.22-1.088l.02-.113l1.027-4.455a1.5 1.5 0 0 1 .29-.598l.111-.125zm-.707 3.535l-8.99 8.99l-.636 2.758l2.758-.637l8.99-8.99l-2.122-2.12Zm3.536-2.121a1 1 0 0 0-1.32-.083l-.094.083l-.708.707l2.122 2.121l.707-.707a1 1 0 0 0 .083-1.32l-.083-.094z" />
          </g>
        </svg>
      </a>
    </div>
    <!-- END EDIT BUTTON -->

  </main>

  <!-- JS -->
  <script src="./js/pages/preview_form.js"></script>
  <!-- END JS -->
</body>

</html>