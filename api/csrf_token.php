<?php
session_start();
require_once __DIR__ . '/../utils/csrf.php';

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'ok' => true,
    'token' => generate_csrf_token()
]);
?>