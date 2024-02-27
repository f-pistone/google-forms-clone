<?php
include_once("./database/conn.php");
session_start();
if (empty($_SESSION['id_user'])) {
  header("Location: login.php");
}
$id_user = (int)$_SESSION['id_user'];

$sqlGetUser = "SELECT first_name_user, last_name_user, email_user FROM users WHERE id_user = $id_user";
$queryGetUser = mysqli_query($conn, $sqlGetUser) or die("Error: get user");
while ($rowGetUser = mysqli_fetch_assoc($queryGetUser)) {
  $first_name_user = $rowGetUser['first_name_user'];
  $last_name_user = $rowGetUser['last_name_user'];
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
      <a href="./index.php" class="shrink-0 inline-block">
        <img src="./assets/images/google-forms-logo.svg" class="w-[40px] aspect-square" alt="Logo">
      </a>
      <div class="text-center">
        <h1 class="text-2xl text-gray-600">Forms</h1>
      </div>
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
  <main class="mt-5 p-2">
    <div class="my-container">

      <div class="border rounded">

        <div class="p-5">
          <h1 class="text-2xl">Informations</h1>
        </div>

        <button type="button" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Profile image</span>
            </div>
            <div>
              <span class="text-gray-500">Add an image to customize your account</span>
            </div>
          </div>
          <div class="shrink-0 w-[50px] aspect-square rounded-full">
            <img class="w-full h-full rounded-full object-contain" src="./assets/images/user-image-placeholder.png" alt="User Image">
          </div>
        </button>

        <button type="button" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Full name</span>
            </div>
            <div>
              <span><?= $first_name_user . " " . $last_name_user ?></span>
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

        <button type="button" class="p-5 w-full flex items-center gap-5 cursor-pointer text-left border-b hover:bg-gray-100">
          <div class="grow flex flex-wrap items-center gap-1">
            <div class="w-full md:w-[150px]">
              <span class="text-sm text-gray-500 font-medium">Email</span>
            </div>
            <div>
              <span><?= $email_user ?></span>
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

        <a href="./change_password.php" class="p-5 flex items-center gap-5 cursor-pointer hover:bg-gray-100">
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

  <!-- JS -->
  <script src="./js/pages/user_settings.js"></script>
  <!-- END JS -->
</body>

</html>