<?php
// Initialize variables for error messages
$usernameError = "";
$passwordError = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the submitted username and password
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Validate the username and password (example only, not secure!)
  $validUsername = "admin";
  $validPassword = "password";

  if ($username === $validUsername && $password === $validPassword) {
    // Authentication successful, create a login token
    $token = md5(uniqid());

    // Create a PHP file with the token that will log you in
    $loginFileContent = '<?php $token = "' . $token . '"; ?>';
    $loginFileName = 'login_' . $token . '.php';
    file_put_contents($loginFileName, $loginFileContent);

    // Provide the PHP file as a downloadable file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $loginFileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($loginFileName));
    readfile($loginFileName);

    // Delete the generated PHP file
    unlink($loginFileName);

    exit;
  } else {
    // Authentication failed, display error messages
    if ($username !== $validUsername) {
      $usernameError = "Incorrect username";
    }
    if ($password !== $validPassword) {
      $passwordError = "Incorrect password";
    }
  }
}
?>

<!-- Display error messages -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <div>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <span class="error"><?php echo $usernameError; ?></span>
  </div>
  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <span class="error"><?php echo $passwordError; ?></span>
  </div>
  <button type="submit">Login</button>
</form>
