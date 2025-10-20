<?php
require_once __DIR__ .'/utils/db.php';
require_once __DIR__ .'/utils/functions.php';
session_start();

$id = $_GET['id'] ?? null;
$article = $id ? get_article($id) : null;

if($_SERVER['REQUEST_METHOD']=='POST'){
    $id = trim($_POST['id']);
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    try{
        update_article($id, $titre, $contenu);
        setFlash('Article modifié avec succès', 'success');
        header('Location: list.php');
        exit;
    }catch(PDOException $e){
      setFlash('Erreur: ' . $e->getMessage(), 'error');
    }
}

$success_message = getFlash('success');
$error_message = getFlash('error');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href='css/style.css'>
        <title>Modification Article</title>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Modifier un article</h1>
            </div>

            <?php if ($success_message): ?>
                <div class="flash-message flash-success">
                    ✅ <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="flash-message flash-error">
                    ❌ <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST">
                    <!-- Champ caché pour l'ID -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">
                    
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" class="form-control" 
                               value="<?= htmlspecialchars($article['titre']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea name="contenu" id="contenu" class="form-control"><?= htmlspecialchars($article['contenu']) ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 Mettre à jour
                        </button>
                        <a href="list.php" class="btn btn-secondary">
                            ↩️ Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>