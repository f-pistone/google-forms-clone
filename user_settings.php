<?php
include_once("./database/conn.php");
session_start();
if (empty($_SESSION['id_user'])) {
  header("Location: login.php");
}
$id_user = (int)$_SESSION['id_user'];

$sqlGetUser = "SELECT first_name_user, last_name_user, image_user, email_user FROM users WHERE id_user = $id_user";
$queryGetUser = mysqli_query($conn, $sqlGetUser) or die("Error: get user");
while ($rowGetUser = mysqli_fetch_assoc($queryGetUser)) {
  $first_name_user = $rowGetUser['first_name_user'];
  $first_name_user_html = htmlspecialchars($first_name_user, ENT_QUOTES);
  $last_name_user = $rowGetUser['last_name_user'];
  $last_name_user_html = htmlspecialchars($last_name_user, ENT_QUOTES);
  $email_user = $rowGetUser['email_user'];
  $email_user_html = htmlspecialchars($email_user, ENT_QUOTES);
  $image_user = (!empty($rowGetUser['image_user'])) ? "./" . $rowGetUser['image_user'] : "./assets/images/user-image-placeholder.jpg";
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <!-- HEADER -->
  <header class="h-[65px] p-4 flex justify-between items-center gap-12 border-b">
    <div class="flex items-center gap-2">
      <a href="./index.php" class="shrink-0 inline-block">
        <img src="./assets/images/google-forms-logo.svg" class="w-[40px] aspect-square" alt="Logo">
      </a>
      <div class="text-center">
        <h1 class="text-2xl text-gray-600">Forms</h1>
      </div>
    </div>
    <div class="shrink-0 relative">
      <button type="button" class="open-profile-box-button w-[50px] aspect-square rounded-full p-1 hover:bg-gray-100 focus:bg-gray-200">
        <img class="image-user w-[50px] aspect-square border rounded-full object-contain" src="<?= $image_user ?>" alt="Profile Image">
      </button>
      <!-- PROFILE BOX -->
      <div id="profile-box" class="hidden fixed sm:absolute z-[9999] right-0 top-0 sm:top-[unset] w-screen sm:w-[435px] h-screen sm:h-[385px] p-4 bg-slate-100 border rounded-lg shadow-lg flex flex-col items-center gap-5">
        <div class="relative w-full flex justify-center items-center gap-2">
          <span class="text-center break-all"><?= $email_user ?></span>
          <button type="button" class="open-profile-box-button absolute right-0 p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-200 focus:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
              <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z"></path>
            </svg>
          </button>
        </div>
        <div class="h-full flex flex-col items-center gap-3">
          <div>
            <img class="image-user w-[80px] aspect-square border rounded-full object-contain" src="<?= $image_user ?>" alt="Profile Image">
          </div>
          <div>
            <h2 class="text-2xl text-center break-all">Hi <?= $first_name_user ?></h2>
          </div>
          <div class="text-center">
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
  <main class="mt-5 p-2">
    <div class="my-container">

      <div class="border rounded">

        <div class="p-5">
          <h1 class="text-2xl">Informations</h1>
        </div>

        <button type="button" id="open_change_image_user_modal" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Profile image</span>
            </div>
            <div>
              <span class="text-gray-500">Add an image to customize your account</span>
            </div>
          </div>
          <div class="shrink-0">
            <img class="image-user w-[50px] aspect-square border rounded-full object-contain" src="<?= $image_user ?>" alt="User Image">
          </div>
        </button>

        <button type="button" id="open_change_name_user_modal" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Full name</span>
            </div>
            <div>
              <span id="name_user"><?= $first_name_user . " " . $last_name_user ?></span>
            </div>
          </div>
          <div>
            <span class="text-xl">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z" />
              </svg>
            </span>
          </div>
        </button>

        <button type="button" id="open_change_email_user_modal" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Email</span>
            </div>
            <div>
              <span id="email_user"><?= $email_user ?></span>
            </div>
          </div>
          <div>
            <span class="text-xl">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z" />
              </svg>
            </span>
          </div>
        </button>

        <a href="./request_change_password.php" class="p-5 flex items-center gap-5 cursor-pointer hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Password</span>
            </div>
            <div>
              <span class="text-blue-500">Change password</span>
            </div>
          </div>
          <div>
            <span class="text-xl">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z" />
              </svg>
            </span>
          </div>
        </a>

      </div>

    </div>
  </main>
  <!-- END MAIN -->

  <!-- CHANGE NAME USER MODAL -->
  <dialog id="change_name_user_modal" class="modal p-5 w-[650px] rounded-lg shadow">
    <div class="mb-5">
      <label for="new_first_name_user" class="block mb-1">First name</label>
      <input type="text" id="new_first_name_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" data-old-value="<?= $first_name_user_html ?>" value="<?= $first_name_user ?>">
    </div>
    <div class="mb-5">
      <label for="new_last_name_user" class="block mb-1">Last name</label>
      <input type="text" id="new_last_name_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" data-old-value="<?= $last_name_user_html ?>" value="<?= $last_name_user ?>">
    </div>
    <div class="flex flex-wrap justify-end items-center gap-2">
      <button type="button" id="close_change_name_user_modal" class="px-5 py-2 text-blue-500 rounded-full hover:bg-blue-100 focus:bg-blue-200 transition">
        Back
      </button>
      <button type="button" id="change_name_user_button" class="px-5 py-2 text-white rounded-full bg-blue-700 hover:bg-blue-600 hover:shadow-lg focus:bg-blue-500">
        Save
      </button>
    </div>

  </dialog>
  <!-- END CHANGE NAME USER MODAL -->

  <!-- CHANGE EMAIL USER MODAL -->
  <dialog id="change_email_user_modal" class="modal p-5 w-[650px] rounded-lg shadow">
    <div class="mb-5">
      <label for="new_email_user" class="block mb-1">Email</label>
      <input type="text" id="new_email_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" data-old-value="<?= $email_user_html ?>" value="<?= $email_user ?>">
    </div>
    <div class="flex flex-wrap justify-end items-center gap-2">
      <button type="button" id="close_change_email_user_modal" class="px-5 py-2 text-blue-500 rounded-full hover:bg-blue-100 focus:bg-blue-200 transition">
        Back
      </button>
      <button type="button" id="change_email_user_button" class="px-5 py-2 text-white rounded-full bg-blue-700 hover:bg-blue-600 hover:shadow-lg focus:bg-blue-500">
        Save
      </button>
    </div>

  </dialog>
  <!-- END CHANGE EMAIL USER MODAL -->

  <!-- CHANGE IMAGE USER MODAL -->
  <dialog id="change_image_user_modal" class="modal w-[400px] rounded-lg shadow">
    <div class="p-2">
      <button type="button" id="close_change_image_user_modal" class="p-3 aspect-square rounded-full flex justify-center items-center text-lg text-gray-500 transition hover:bg-gray-100 focus:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40">
          <path fill="currentColor" d="M21.499 19.994L32.755 8.727a1.064 1.064 0 0 0-.001-1.502c-.398-.396-1.099-.398-1.501.002L20 18.494L8.743 7.224c-.4-.395-1.101-.393-1.499.002a1.05 1.05 0 0 0-.309.751c0 .284.11.55.309.747L18.5 19.993L7.245 31.263a1.064 1.064 0 0 0 .003 1.503c.193.191.466.301.748.301h.006c.283-.001.556-.112.745-.305L20 21.495l11.257 11.27c.199.198.465.308.747.308a1.058 1.058 0 0 0 1.061-1.061c0-.283-.11-.55-.31-.747z"></path>
        </svg>
      </button>
    </div>
    <div class="mb-5 px-5">
      <label for="input_image_user" class="inline-block mb-1 text-xl">Profile image</label>
    </div>
    <div class="p-5 flex flex-col items-center gap-2">
      <div class="mb-5 cursor-pointer" id="current_image_user">
        <img class="image-user w-[300px] aspect-square border rounded-full object-contain" src="<?= $image_user ?>" alt="User Image">
      </div>
      <div class="w-full">
        <button type="button" id="open_input_image_user_button" class="p-2 w-full flex justify-center items-center gap-2 rounded border font-medium text-sm text-blue-500 bg-white hover:text-blue-600 hover:bg-slate-100 focus:bg-blue-100">
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
              <path fill="currentColor" d="M3 8c0 .55.45 1 1 1s1-.45 1-1V6h2c.55 0 1-.45 1-1s-.45-1-1-1H5V2c0-.55-.45-1-1-1s-1 .45-1 1v2H1c-.55 0-1 .45-1 1s.45 1 1 1h2z" />
              <circle cx="13" cy="14" r="3" fill="currentColor" />
              <path fill="currentColor" d="M21 6h-3.17l-1.24-1.35A1.99 1.99 0 0 0 15.12 4h-6.4c.17.3.28.63.28 1c0 1.1-.9 2-2 2H6v1c0 1.1-.9 2-2 2c-.37 0-.7-.11-1-.28V20c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2m-8 13c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5" />
            </svg>
          </span>
          <span>Add a profile image</span>
        </button>
      </div>
    </div>
    <input type="file" id="input_image_user" accept="image/jpeg, image/png" class="hidden">
  </dialog>
  <!-- END CHANGE IMAGE USER MODAL -->

  <!-- JS -->
  <script src="./js/pages/user_settings.js"></script>
  <!-- END JS -->
</body>

</html>