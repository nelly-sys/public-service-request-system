<?php
require __DIR__ . '/../config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
    http_response_code(403); exit('Invalid security token. Return to the dashboard and try again.');
}
$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
$status = $_POST['status'] ?? '';
$allowed = ['Pending', 'In Progress', 'Resolved', 'Rejected'];
if (!$id || !in_array($status, $allowed, true)) {
    $_SESSION['flash'] = 'Invalid request or status.';
} else {
    $stmt = $pdo->prepare('UPDATE requests SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
    $stmt->execute([$status, $id]);
    $_SESSION['flash'] = 'Request status updated.';
}
header('Location: dashboard.php'); exit;
