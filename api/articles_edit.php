<?php
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../utils/csrf.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    // GET /api/articles_edit.php?id=123  
    if ($method === 'GET') {
        $id = $_GET['id'] ?? '';
        if ($id === '' || !ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Paramètre id manquant ou invalide']);
            exit;
        }

        $article = get_article((int)$id);
        if (!$article) {
            http_response_code(404);
            echo json_encode(['ok' => false, 'error' => 'Article introuvable']);
            exit;
        }

        echo json_encode(['ok' => true, 'article' => $article], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // POST /api/articles_edit.php 
    if ($method === 'POST') {
        // Vérification CSRF
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF invalide']);
            exit;
        }

        $id      = trim($_POST['id'] ?? '');
        $titre   = trim($_POST['titre'] ?? '');
        $contenu = trim($_POST['contenu'] ?? '');

        // Validations simples
        if ($id === '' || !ctype_digit($id)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'id invalide']);
            exit;
        }
        if ($titre === '' || $contenu === '') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Titre et contenu sont obligatoires']);
            exit;
        }

        $existing = get_article((int)$id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['ok' => false, 'error' => 'Article introuvable']);
            exit;
        }

        // Mise à jour
        update_article((int)$id, $titre, $contenu);

        echo json_encode(
            ['ok' => true, 'message' => 'Article mis à jour', 'id' => (int)$id],
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }

    // Méthode non supportée
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
?>