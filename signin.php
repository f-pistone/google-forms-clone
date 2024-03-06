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
      <!-- SIGN IN FORM -->
      <form id="sign_in_form" class="p-7 grid grid-cols-1 gap-5 border rounded">
        <div class="flex flex-col items-center gap-2">
          <div>
            <img src="./assets/images/google-forms-logo.svg" class="w-[50px] aspect-square" alt="Logo">
          </div>
          <div class="text-center">
            <h1 class="text-3xl">Sign In</h1>
            <h2 class="text-sm text-slate-600">Insert your informations</h2>
          </div>
        </div>
        <div class="input-area">
          <label for="first_name_user" class="inline-block text-lg">First Name</label>
          <input type="text" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="first_name_user" id="first_name_user" placeholder="First Name" value="" required>
          <span class="error-message hidden text-sm text-red-500">Insert your first name</span>
        </div>
        <div class="input-area">
          <label for="last_name_user" class="inline-block text-lg">Last Name</label>
          <input type="text" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="last_name_user" id="last_name_user" placeholder="Last Name" value="" required>
          <span class="error-message hidden text-sm text-red-500">Insert your last name</span>
        </div>
        <div class="input-area">
          <label for="email_user" class="inline-block text-lg">Email</label>
          <input type="email" class="py-2 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="email_user" id="email_user" placeholder="Email" value="" required>
          <span class="error-message hidden text-sm text-red-500">Insert your email</span>
        </div>
        <div class="input-area">
          <label for="password_user" class="inline-block text-lg">Password</label>
          <div class="relative">
            <input type="password" class="py-2 pr-7 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="password_user" id="password_user" placeholder="Password" value="" required>
            <button type="button" class="show-password absolute z-[999] right-0 top-1/2 -translate-y-1/2 text-xl text-gray-500">
              <span class="eye-closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                  <path fill="currentColor" d="M432 448a15.92 15.92 0 0 1-11.31-4.69l-352-352a16 16 0 0 1 22.62-22.62l352 352A16 16 0 0 1 432 448m-176.34-64c-41.49 0-81.5-12.28-118.92-36.5c-34.07-22-64.74-53.51-88.7-91v-.08c19.94-28.57 41.78-52.73 65.24-72.21a2 2 0 0 0 .14-2.94L93.5 161.38a2 2 0 0 0-2.71-.12c-24.92 21-48.05 46.76-69.08 76.92a31.92 31.92 0 0 0-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416a239.13 239.13 0 0 0 75.8-12.58a2 2 0 0 0 .77-3.31l-21.58-21.58a4 4 0 0 0-3.83-1a204.8 204.8 0 0 1-51.16 6.47m235.18-145.4c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96a227.34 227.34 0 0 0-74.89 12.83a2 2 0 0 0-.75 3.31l21.55 21.55a4 4 0 0 0 3.88 1a192.82 192.82 0 0 1 50.21-6.69c40.69 0 80.58 12.43 118.55 37c34.71 22.4 65.74 53.88 89.76 91a.13.13 0 0 1 0 .16a310.72 310.72 0 0 1-64.12 72.73a2 2 0 0 0-.15 2.95l19.9 19.89a2 2 0 0 0 2.7.13a343.49 343.49 0 0 0 68.64-78.48a32.2 32.2 0 0 0-.1-34.78" />
                  <path fill="currentColor" d="M256 160a95.88 95.88 0 0 0-21.37 2.4a2 2 0 0 0-1 3.38l112.59 112.56a2 2 0 0 0 3.38-1A96 96 0 0 0 256 160m-90.22 73.66a2 2 0 0 0-3.38 1a96 96 0 0 0 115 115a2 2 0 0 0 1-3.38Z" />
                </svg>
              </span>
              <span class="hidden eye-opened">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                  <circle cx="256" cy="256" r="64" fill="currentColor" />
                  <path fill="currentColor" d="M490.84 238.6c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96c-42.52 0-84.33 12.15-124.27 36.11c-40.73 24.43-77.63 60.12-109.68 106.07a31.92 31.92 0 0 0-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416c46.71 0 93.81-14.43 136.2-41.72c38.46-24.77 72.72-59.66 99.08-100.92a32.2 32.2 0 0 0-.1-34.76M256 352a96 96 0 1 1 96-96a96.11 96.11 0 0 1-96 96" />
                </svg>
              </span>
            </button>
          </div>
          <span class="error-message hidden text-sm text-red-500">Insert your password</span>
        </div>
        <div class="input-area">
          <label for="confirm_password_user" class="inline-block text-lg">Confirm Password</label>
          <div class="relative">
            <input type="password" class="py-2 pr-7 w-full border-b hover:border-blue-500 focus:outline-none focus:border-blue-500 transition" name="confirm_password_user" id="confirm_password_user" placeholder="Confirm Password" value="" required>
            <button type="button" class="show-password absolute z-[999] right-0 top-1/2 -translate-y-1/2 text-xl text-gray-500">
              <span class="eye-closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                  <path fill="currentColor" d="M432 448a15.92 15.92 0 0 1-11.31-4.69l-352-352a16 16 0 0 1 22.62-22.62l352 352A16 16 0 0 1 432 448m-176.34-64c-41.49 0-81.5-12.28-118.92-36.5c-34.07-22-64.74-53.51-88.7-91v-.08c19.94-28.57 41.78-52.73 65.24-72.21a2 2 0 0 0 .14-2.94L93.5 161.38a2 2 0 0 0-2.71-.12c-24.92 21-48.05 46.76-69.08 76.92a31.92 31.92 0 0 0-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416a239.13 239.13 0 0 0 75.8-12.58a2 2 0 0 0 .77-3.31l-21.58-21.58a4 4 0 0 0-3.83-1a204.8 204.8 0 0 1-51.16 6.47m235.18-145.4c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96a227.34 227.34 0 0 0-74.89 12.83a2 2 0 0 0-.75 3.31l21.55 21.55a4 4 0 0 0 3.88 1a192.82 192.82 0 0 1 50.21-6.69c40.69 0 80.58 12.43 118.55 37c34.71 22.4 65.74 53.88 89.76 91a.13.13 0 0 1 0 .16a310.72 310.72 0 0 1-64.12 72.73a2 2 0 0 0-.15 2.95l19.9 19.89a2 2 0 0 0 2.7.13a343.49 343.49 0 0 0 68.64-78.48a32.2 32.2 0 0 0-.1-34.78" />
                  <path fill="currentColor" d="M256 160a95.88 95.88 0 0 0-21.37 2.4a2 2 0 0 0-1 3.38l112.59 112.56a2 2 0 0 0 3.38-1A96 96 0 0 0 256 160m-90.22 73.66a2 2 0 0 0-3.38 1a96 96 0 0 0 115 115a2 2 0 0 0 1-3.38Z" />
                </svg>
              </span>
              <span class="hidden eye-opened">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                  <circle cx="256" cy="256" r="64" fill="currentColor" />
                  <path fill="currentColor" d="M490.84 238.6c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96c-42.52 0-84.33 12.15-124.27 36.11c-40.73 24.43-77.63 60.12-109.68 106.07a31.92 31.92 0 0 0-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416c46.71 0 93.81-14.43 136.2-41.72c38.46-24.77 72.72-59.66 99.08-100.92a32.2 32.2 0 0 0-.1-34.76M256 352a96 96 0 1 1 96-96a96.11 96.11 0 0 1-96 96" />
                </svg>
              </span>
            </button>
          </div>
          <span class="error-message hidden text-sm text-red-500">Confirm your password</span>
        </div>
        <div class="text-right">
          <button type="button" id="sign_in_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">Sign In</button>
        </div>
      </form>
      <!-- END SIGN IN FORM -->
    </div>
  </main>
  <!-- JS -->
  <script src="./js/pages/signin.js"></script>
  <!-- END JS -->
</body>

</html>