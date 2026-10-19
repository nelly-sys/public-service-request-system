
<?php
require_once __DIR__ . '/public_service_request_system/config.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $phone === '' || $password === '') {
        $message = 'Please fill in every field.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $message = 'Password must be at least 8 characters.';
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                'INSERT INTO citizens (full_name, email, phone, password)
                 VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$name, $email, $phone, $hash]);

            $message = 'Registration successful! You can now log in.';
            $success = true;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $message = 'That email address is already registered.';
            } else {
                $message = 'Registration failed. Please check the database connection.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citizen Registration</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="container">
        <h1>Citizen Registration</h1>
        <p>Create an account to use public services.</p>

        <?php if ($message !== ''): ?>
            <p role="status">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="post" action="register.php">
            <label for="full_name">Full name</label>
            <input id="full_name" name="full_name" maxlength="100" required>

            <label for="email">Email address</label>
            <input id="email" name="email" type="email"
                   maxlength="150" required>

            <label for="phone">Phone number</label>
            <input id="phone" name="phone" type="tel"
                   maxlength="20" required>

            <label for="password">Password (at least 8 characters)</label>
            <input id="password" name="password" type="password"
                   minlength="8" autocomplete="new-password" required>

            <button type="submit">Create Account</button>
        </form>
        <?php endif; ?>

        <p>Already registered? <a href="login.php">Log in here</a>.</p>
        <p><a href="index.php">Back to home</a></p>
    </main>
</body>
</html>
