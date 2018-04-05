<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php";
            
                $titre = $_GET['nom'];
                $requete = getDb() -> prepare ("select * from image where img_titre = '$titre'");
                $requete -> execute ();
                $ligne = $requete -> fetch();
                unlink($ligne['img_adresse']);//supprime la photo dans le dossier image du site
                $requete2 = getDb() -> prepare("delete from image where img_titre = '$titre'") ;
                $requete2 -> execute();//supprime la photo de la base de donnée
            
                redirect('Accueil_Admin.php');
            
            require_once "includes/footer.php"; ?>
        </div>
        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>