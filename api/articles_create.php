<?php 
require_once __DIR__ .'/../utils/functions.php'; 
header('content-type: application/json; charset="UTF-8"');

    try{
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
