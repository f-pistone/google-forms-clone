<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>
  <main>
    <div class="my-container mt-12 p-2">
      <form class="p-7 grid grid-cols-1 gap-5 border rounded">
        <div class="flex flex-col items-center gap-2">
          <div>
            <img src="./assets/images/google-forms-logo.svg" class="w-[50px] aspect-square" alt="Logo">
          </div>
          <div class="text-center">
            <h1 class="text-3xl">Sign In</h1>
            <h2 class="text-sm text-slate-600">Insert your informations</h2>
          </div>
        </div>
        <div>
          <label for="first_name_user" class="inline-block text-lg">First Name</label>
          <input type="text" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="first_name_user" id="first_name_user" placeholder="First Name" value="">
        </div>
        <div>
          <label for="last_name_user" class="inline-block text-lg">Last Name</label>
          <input type="text" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="last_name_user" id="last_name_user" placeholder="Last Name" value="">
        </div>
        <div>
          <label for="email_user" class="inline-block text-lg">Email</label>
          <input type="email" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="email_user" id="email_user" placeholder="Email" value="">
        </div>
        <div>
          <label for="password_user" class="inline-block text-lg">Password</label>
          <input type="password" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="password_user" id="password_user" placeholder="Password" value="">
        </div>
        <div>
          <label for="confirm_password_user" class="inline-block text-lg">Confirm Password</label>
          <input type="password" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="confirm_password_user" id="confirm_password_user" placeholder="Confirm Password" value="">
        </div>
        <div class="text-right">
          <button type="button" id="sign_in_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">Sign In</button>
        </div>
      </form>
    </div>
  </main>
  <!-- JS -->
  <script src="./js/pages/signin.js"></script>
  <!-- END JS -->
</body>

</html>