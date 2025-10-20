<?php
// api/articles_delete.php
require_once __DIR__ . '/../utils/functions.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $id = (int)($_POST['id'] ?? 0);

    //validations
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'ID invalide']);
        exit;
    }

    // 2) SUPPRIMER EN BDD
    delete_article($id);

    echo json_encode(['ok' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
