<?php
include_once("./database/conn.php");

$email_user = $_GET['e'];
$id_user = (int)$_GET['u'];
$uniqid = $_GET['uid'];

$sqlCheckUser = "SELECT id_user FROM users WHERE id_user = $id_user AND email_user = '$email_user' AND uniqid = '$uniqid'";
$queryCheckUser = mysqli_query($conn, $sqlCheckUser) or die("Error: check user");
$user_check = (int)mysqli_num_rows($queryCheckUser);

if ($user_check == 0) {
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include_once("./components/head.php") ?>

<body>

  <main class="mt-5 p-2">
    <div class="my-container">
      <form id="change_password_form" class="p-7 border rounded flex flex-col gap-5">
        <div>
          <h1 class="text-2xl">New password</h1>
          <h2 class="text-gray-500">Choose a new password</h2>
        </div>
        <div>
          <label for="password_user" class="block mb-1">Password</label>
          <div class="relative">
            <input type="password" id="password_user" name="new_password_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" placeholder="Password" value="" required>
            <span class="error-message hidden text-sm text-red-500">Insert your password</span>
            <button type="button" class="show-password absolute z-[999] right-2 top-1/2 -translate-y-1/2 text-xl text-gray-500">
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
        </div>
        <div>
          <label for="confirm_password_user" class="block mb-1">Confirm Password</label>
          <div class="relative">
            <input type="password" id="confirm_password_user" class="w-full p-3 border border-gray-400 rounded hover:border-black focus:border-blue-500 focus:outline-none" placeholder="Confirm Password" value="" required>
            <span class="error-message hidden text-sm text-red-500">Confirm your password</span>
            <button type="button" class="show-password absolute z-[999] right-2 top-1/2 -translate-y-1/2 text-xl text-gray-500">
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
        </div>
        <div class="text-right">
          <button type="button" id="change_password_button" class="px-4 py-2 text-white rounded bg-blue-500 hover:bg-blue-600">
            Change
          </button>
        </div>
        <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>" required>
        <input type="hidden" name="email_user" id="email_user" value="<?= $email_user ?>" required>
        <input type="hidden" name="uniqid" id="uniqid" value="<?= $uniqid ?>" required>
      </form>
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