<?php
session_start();
if (empty($_SESSION['id_user'])) {
  header("Location: login.php");
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
        <h1 class="text-2xl text-slate-600">Forms</h1>
      </div>
    </div>
    <div class="grow flex">
      <input type="search" class="p-3 w-full rounded bg-slate-100 focus:outline-none focus:border focus:bg-white focus:shadow" placeholder="Search" value="">
    </div>
    <div class="shrink-0">
      <img class="w-[40px] aspect-square rounded-full object-contain" src="https://lh3.googleusercontent.com/-t8idYWqDDbg/AAAAAAAAAAI/AAAAAAAAAAA/ALKGfklvc8tPxaawNFNx_MuXusN0UiODZQ/photo.jpg" alt="Profile Image">
    </div>
  </header>
  <!-- END HEADER -->

  <!-- MAIN -->
  <main>

    <!-- CREATE FORM -->
    <section class="bg-slate-100">
      <div class="my-container p-2">
        <h1 class="px-1 py-3 text-lg">Create a new form</h1>
        <div class="flex gap-5">
          <!-- EMPTY FORM -->
          <div class="w-[165px]">
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
      <ul class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <li>
          <!-- FORM -->
          <div class="w-full cursor-pointer border rounded hover:border-purple-500">
            <div class="border-b">
              <img class="w-full rounded-t" src="./assets/images/form-image-fake.png" alt="Form Image">
            </div>
            <div class="p-3">
              <h4 class="font-medium mb-2">Title</h4>
              <div class="flex items-center gap-2">
                <div>
                  <img src="./assets/images/google-forms-logo.svg" class="w-[20px] aspect-square" alt="Form Icon">
                </div>
                <div>
                  <span class="text-xs text-slate-600">
                    Aperto 18:20
                  </span>
                </div>
                <div class="ml-auto relative">
                  <button type="button" class="flex justify-center items-center w-[30px] aspect-square text-xl text-slate-600 rounded-full hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                      <g fill="currentColor">
                        <circle cx="10" cy="15" r="2" />
                        <circle cx="10" cy="10" r="2" />
                        <circle cx="10" cy="5" r="2" />
                      </g>
                    </svg>
                  </button>
                  <!-- OPTIONS MENU -->
                  <div class="hidden absolute z-[9999] left-0 bottom-[30px] -translate-x-1/2 w-[250px] h-fit bg-white border rounded shadow">
                    <ul>
                      <li class="p-3 flex items-center gap-3 hover:bg-slate-100">
                        <span class="text-lg font-bold">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="4" d="M4 8h28m-4 13h16M18 42V8m18 34V21" />
                          </svg>
                        </span>
                        <span>Rename</span>
                      </li>
                      <li class="p-3 flex items-center gap-3 hover:bg-slate-100">
                        <span class="text-lg font-bold">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="m112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" />
                            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224l8 224m136-224l-8 224" />
                          </svg>
                        </span>
                        <span>Remove</span>
                      </li>
                      <li class="p-3 flex items-center gap-3 hover:bg-slate-100">
                        <span class="text-lg font-bold">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 2048 2048">
                            <path fill="currentColor" d="M2048 0v1664h-384v384H0V384h384V0zm-128 1536V128H512v256h256v128H128v1408h1408v-640h128v256zm-979-339l-90-90l594-595h-421V384h640v640h-128V603z" />
                          </svg>
                        </span>
                        <span>Open in a new window</span>
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
      </ul>
      <!-- END LIST OF FORMS -->

    </div>
    <!-- END FORMS -->

  </main>
  <!-- END MAIN -->

</body>

</html>