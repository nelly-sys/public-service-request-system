
<?php
require_once __DIR__ . '/../config.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$now = time();
$window = 15 * 60;
$maxAttempts = 5;

// Keep only failed attempts from the last 15 minutes.
$_SESSION['login_attempts'] = array_values(
    array_filter(
        $_SESSION['login_attempts'] ?? [],
        fn($time) => $time > $now - $window
    )
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (count($_SESSION['login_attempts']) >= $maxAttempts) {
        $error = 'Too many failed attempts. Please wait before trying again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare(
            'SELECT id, username, password_hash
             FROM admins
             WHERE username = ?'
        );
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            unset($_SESSION['login_attempts']);

            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header('Location: dashboard.php');
            exit;
        }

        $_SESSION['login_attempts'][] = $now;
        $error = 'Invalid username or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="../index.php">Public Service Portal</a>
    <nav><a href="../index.php">Citizen portal</a></nav>
</header>

<main class="container narrow">
    <section class="hero">
        <p class="eyebrow">STAFF AREA</p>
        <h1>Administrator login</h1>
        <p>Sign in to manage incoming requests.</p>
    </section>

    <section class="panel">
        <?php if ($error): ?>
            <div class="notice error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label>
                Username
                <input name="username" autocomplete="username" required>
            </label>

            <label>
                Password
                <input type="password" name="password"
                       autocomplete="current-password" required>
            </label>

            <button type="submit">Sign in</button>
        </form>

        <p class="muted">
            Never use a sample password on a public server.
        </p>
    </section>
</main>
</body>
</html>
