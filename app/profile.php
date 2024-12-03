<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("No ID provided!");
}

$query = $conn->prepare("SELECT username FROM users WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$query->bind_result($username);
$query->fetch();
$query->close();

if (!$username) {
    die("User not found!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    if (strlen($new_password) < 6) {
        echo "<p style='color: red;'>Password must be at least 6 characters long!</p>";
    } else {
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", md5($new_password), $id);
        $update->execute();
        if ($update->affected_rows > 0) {
            echo "<p style='color: green;'>Password updated successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to update password!</p>";
        }
        $update->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Profile of <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></h2>
    <p>You can change your password here.</p>
    <form method="POST" class="form-group">
        <label for="new_password" class="form-label">New Password:</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-3">Change Password</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
