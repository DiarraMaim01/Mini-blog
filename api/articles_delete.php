<?php
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../utils/csrf.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Vérifier CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Token CSRF invalide']);
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);

    //validation de l'id
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
?>