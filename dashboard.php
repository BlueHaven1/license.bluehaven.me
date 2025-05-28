<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}

$user = $_SESSION['user'];
$avatarUrl = $user['avatar']
  ? "https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.png"
  : "https://cdn.discordapp.com/embed/avatars/0.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | BlueHaven License System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(145deg, #1a1a1a, #0f1b2b);
      color: #ffffff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .dashboard-container {
      background-color: #1e2a38;
      padding: 40px 60px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      max-width: 500px;
      width: 100%;
      animation: fadeIn 0.7s ease;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .avatar {
      border-radius: 50%;
      margin-bottom: 20px;
      width: 100px;
      height: 100px;
    }

    .info {
      font-size: 16px;
      margin-bottom: 20px;
      color: #cbd5e1;
    }

    .logout-btn {
      display: inline-block;
      background-color: #dc3545;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #a62d3b;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <img src="<?= $avatarUrl ?>" class="avatar" alt="Discord Avatar">
    <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
    <p class="info">Discord ID: <?= $user['id'] ?>#<?= $user['discriminator'] ?></p>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>
</body>
</html>
