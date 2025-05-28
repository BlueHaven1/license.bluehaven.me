<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$clientId = $_ENV['DISCORD_CLIENT_ID'];
$redirectUri = urlencode($_ENV['DISCORD_REDIRECT_URI']); // URL-encoded
$scope = urlencode("identify guilds.members.read");
$oauthUrl = "https://discord.com/api/oauth2/authorize?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=$scope";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login with Discord</title>
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
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .login-container {
      background-color: #1e2a38;
      padding: 40px 60px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      max-width: 400px;
      width: 100%;
      animation: fadeIn 0.7s ease;
    }

    h1 {
      font-size: 26px;
      font-weight: 600;
      margin-bottom: 30px;
    }

    .discord-btn {
      display: inline-block;
      background-color: #5865F2;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .discord-btn:hover {
      background-color: #4752c4;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login to Access License System</h1>
    <a class="discord-btn" href="<?= $oauthUrl ?>">
      Login with Discord
    </a>
  </div>
</body>
</html>
