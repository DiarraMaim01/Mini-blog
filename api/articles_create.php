<?php 
require_once __DIR__ .'/../utils/functions.php'; 
require_once __DIR__ .'/../utils/csrf.php';

header('content-type: application/json; charset="UTF-8"');

try{
    // Vérification CSRF pour les requêtes POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF invalide']);
            exit;
        }
    }

    $titre = trim($_POST['titre']?? '');
    $contenu = trim($_POST['contenu']?? '');

    // validation
    if ($titre === '' || $contenu === '') {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Titre et contenu requis']);
        exit;
    }

    // ajout en BDD
    add_article($titre ,$contenu);
    echo json_encode(['ok'=> true ]);

}catch(PDOException $e){
    http_response_code(500);
    echo json_encode(['ok'=> false , 'error' => $e->getMessage()]);
}
?>