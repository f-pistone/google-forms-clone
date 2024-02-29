<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <main class="mt-5 p-2">
    <div class="my-container">
      <div id="send_email_box" class="p-7 border rounded flex flex-col gap-5">
        <div>
          <h1 class="text-2xl">Change password</h1>
          <h2 class="text-gray-500">Insert your email to receive a link to change your password</h2>
        </div>
        <div>
          <label for="email_user" class="block mb-1">Email</label>
          <input type="email" id="email_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" placeholder="Email" value="">
          <span class="error-message hidden text-sm text-red-500">Insert your email</span>
        </div>
        <div class="text-right">
          <button type="button" id="send_email_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">
            Send
          </button>
        </div>
      </div>
      <div id="success_email_box" class="hidden p-7 border rounded flex items-center gap-5">
        <div class="text-6xl text-green-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="currentColor" d="m10 17l-5-5l1.41-1.42L10 14.17l7.59-7.59L19 8m-7-6A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2" />
          </svg>
        </div>
        <div>
          <h1 class="text-2xl">Email sent</h1>
        </div>
      </div>
    </div>
  </main>

  <!-- JS -->
  <script src="./js/pages/change_password.js"></script>
  <!-- END JS -->
</body>

</html>