<?php
// api/articles.php

require_once __DIR__ .'/../utils/functions.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $articles= get_articles();
    echo json_encode([
        'ok' => true,
        'articles' => $articles
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500); // code d’erreur serveur
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
