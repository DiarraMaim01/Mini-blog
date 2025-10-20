<?php 
function get_pdo(){
    $host ='localhost';
    $dbname ='mini_blog';
    $user ='root';
    $pass ='';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo ;
    }catch(PDOException $e){
        die("Erreur de connexion : " . $e->getMessage());

    }

}
?>