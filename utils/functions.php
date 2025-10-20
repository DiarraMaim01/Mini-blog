<?php
require_once __DIR__ .'/db.php';

 

function add_article($titre , $contenu) : void{
    $pdo= get_pdo();
    $stmt= $pdo->prepare("INSERT INTO articles (titre, contenu) VALUES(?, ?)");
    $stmt->execute([$titre, $contenu]);
    
}

function get_articles() : array {
    $pdo = get_pdo();
    $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function update_article(int $id , string $titre , string $contenu) :void{
     $pdo= get_pdo();
    $stmt= $pdo->prepare("UPDATE  articles SET  titre =? , contenu= ? WHERE id=?");
    $stmt->execute([$titre, $contenu, $id]);

}

function delete_article (int $id) : void {
     $pdo= get_pdo();
    $stmt= $pdo->prepare(" DELETE FROM articles WHERE id=?");
    $stmt->execute([$id]);
    
}


function get_article(int $id) : ?array {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
 
function setFlash(string $message, String $type = 'info') : void {
    $_SESSION['flash'][$type] = $message;
    
}

// recuperer un message flash pour le supprimer
function getFlash(string $type = 'info') : ?string {
    $message = $_SESSION['flash'][$type] ?? null;
    unset($_SESSION['flash'][$type]);
    return $message;
}


?>