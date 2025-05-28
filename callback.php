<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

// Get Discord credentials from .env
$clientId = $_ENV['DISCORD_CLIENT_ID'];
$clientSecret = $_ENV['DISCORD_CLIENT_SECRET'];
$redirectUri = $_ENV['DISCORD_REDIRECT_URI'];
$guildId = $_ENV['DISCORD_GUILD_ID'];
$requiredRoleId = $_ENV['DISCORD_ROLE_ID'];

// Ensure code is passed back
if (!isset($_GET['code'])) {
    die("Authorization code not provided.");
}

$code = $_GET['code'];

// Exchange code for access token
$tokenRequest = curl_init();
curl_setopt_array($tokenRequest, [
    CURLOPT_URL => "https://discord.com/api/oauth2/token",
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => http_build_query([
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => $redirectUri,
        "scope" => "identify guilds.members.read"
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/x-www-form-urlencoded"
    ]
]);

$response = curl_exec($tokenRequest);
curl_close($tokenRequest);

$tokenData = json_decode($response, true);
if (!isset($tokenData['access_token'])) {
    die("Failed to obtain access token.");
}

$accessToken = $tokenData['access_token'];

// Fetch user info
$userRequest = curl_init();
curl_setopt_array($userRequest, [
    CURLOPT_URL => "https://discord.com/api/users/@me",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken"
    ]
]);
$userResponse = curl_exec($userRequest);
curl_close($userRequest);
$user = json_decode($userResponse, true);

// Fetch guild member info
$guildMemberRequest = curl_init();
curl_setopt_array($guildMemberRequest, [
    CURLOPT_URL => "https://discord.com/api/users/@me/guilds/$guildId/member",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken"
    ]
]);
$guildMemberResponse = curl_exec($guildMemberRequest);
curl_close($guildMemberRequest);
$member = json_decode($guildMemberResponse, true);

// Check role
if (!isset($member['roles']) || !in_array($requiredRoleId, $member['roles'])) {
    die("Access denied: You don't have the required Discord role.");
}

// ✅ Success — store session
$_SESSION['user'] = [
    'id' => $user['id'],
    'username' => $user['username'],
    'discriminator' => $user['discriminator'],
    'avatar' => $user['avatar']
];

// Redirect to dashboard or protected area
header("Location: dashboard.php");
exit;
