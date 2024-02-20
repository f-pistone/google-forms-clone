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
      <ul>
        <li>

          <!-- FORM -->
          <div class="w-[200px] cursor-pointer border rounded hover:border-purple-500">
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
                <div class="ml-auto">
                  ...
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