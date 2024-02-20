<?php
session_start();
if (!empty($_SESSION['id_user']) && (int)$_SESSION['id_user'] > 0) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>
  <main>
    <div class="my-container mt-12 p-2">
      <!-- LOG IN FORM -->
      <form id="log_in_form" class="p-7 grid grid-cols-1 gap-5 border rounded">
        <div class="flex flex-col items-center gap-2">
          <div>
            <img src="./assets/images/google-forms-logo.svg" class="w-[50px] aspect-square" alt="Logo">
          </div>
          <div class="text-center">
            <h1 class="text-3xl">Welcome</h1>
          </div>
        </div>
        <div>
          <label for="email_user" class="inline-block text-lg">Email</label>
          <input type="email" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="email_user" id="email_user" placeholder="Email" value="" required>
          <span class="error-message hidden text-sm text-red-500">Insert your email</span>
        </div>
        <div>
          <label for="password_user" class="inline-block text-lg">Password</label>
          <input type="password" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="password_user" id="password_user" placeholder="Password" value="" required>
          <span class="error-message hidden text-sm text-red-500">Insert your password</span>
        </div>
        <div class="text-right">
          <button type="button" id="log_in_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">Log In</button>
          <div class="mt-2">
            <a href="./signin.php" class="text-sm underline hover:text-blue-500">New? Create a new account</a>
          </div>
        </div>
      </form>
      <!-- END LOG IN FORM -->
    </div>
  </main>
  <!-- JS -->
  <script src="./js/pages/login.js"></script>
  <!-- END JS -->
</body>

</html>