<?php

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <main class="mt-5 p-2">
    <div class="my-container">
      <div id="change_password_box" class="p-7 border rounded flex flex-col gap-5">
        <div>
          <h1 class="text-2xl">New password</h1>
          <h2 class="text-gray-500">Choose a new password</h2>
        </div>
        <div>
          <label for="password_user" class="block mb-1">Password</label>
          <input type="password" id="password_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" placeholder="Password" value="">
          <span class="error-message hidden text-sm text-red-500">Insert your password</span>
        </div>
        <div>
          <label for="confirm_password_user" class="block mb-1">Confirm Password</label>
          <input type="password" id="confirm_password_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" placeholder="Confirm Password" value="">
          <span class="error-message hidden text-sm text-red-500">Confirm your password</span>
        </div>
        <div class="text-right">
          <button type="button" id="change_password_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">
            Change
          </button>
        </div>
      </div>
      <div id="success_password_box" class="hidden p-7 border rounded flex items-center gap-5">
        <div class="text-6xl text-green-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="currentColor" d="m10 17l-5-5l1.41-1.42L10 14.17l7.59-7.59L19 8m-7-6A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2" />
          </svg>
        </div>
        <div>
          <h1 class="text-2xl">Password changed</h1>
        </div>
      </div>
    </div>
  </main>

  <!-- JS -->
  <script src="./js/pages/new_password.js"></script>
  <!-- END JS -->
</body>

</html>