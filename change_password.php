<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <main class="mt-5 p-2">
    <div class="my-container">
      <div class="p-7 border rounded flex flex-col gap-5">
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
    </div>
  </main>

  <!-- JS -->
  <script src="./js/pages/change_password.js"></script>
  <!-- END JS -->
</body>

</html>