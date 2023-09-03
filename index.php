<?php
include 'db.php';

$allowed_users = [
    'admin' => 'fleekdapper'
];

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted_username = $_POST['username'];
    $submitted_password = $_POST['password'];

    if (array_key_exists($submitted_username, $allowed_users)) {
        if ($submitted_password === $allowed_users[$submitted_username]) {
            $_SESSION['user'] = $submitted_username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = 'Invalid password';
        }
    } else {
        $error_message = 'Invalid username';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <img src="images/logo.jpg" alt="Logo" class="login-logo">
    <div class="login-header">Inventory Management System</div>
    <form method="post" action="index.php">
      <input type="text" class="login-input" name="username" placeholder="Username" required>
      <input type="password" class="login-input" name="password" placeholder="Password" required>
      <button type="submit" class="login-button">Login</button>
    </form>
    <?php if (isset($error_message)) : ?>
      <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
