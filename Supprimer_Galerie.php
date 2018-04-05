<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?>
            
            <?php 
            $galerie = $_GET['nom'];
            $requete = getDb() -> prepare("select * from image where img_galerie='$galerie'");
            $requete -> execute();
            while($ligne = $requete -> fetch())//supprime toutes les photos de la galerie dans le dossier image du site (ok)
            {
                unlink($ligne['img_adresse']);//ne marche pas sur tout ??
            }
            //supprime le dossier de la galerie dans le dossier image du site (pas ok: directory not empty)
            $requete = getDb() -> prepare("select * from image where img_galerie='$galerie'");
            $requete -> execute();
            $ligne = $requete -> fetch();
            $nomDossier = "images/";
            $nomDossier =  $nomDossier.$ligne['img_galerie']."/";
            rmdir($nomDossier);
            
            //supprime dans la bdd
            $requete2 = getDb() -> prepare ("delete from image where img_adresse like '$nomDossier%'");
            $requete2 -> execute();
            
            redirect('Galerie_Admin.php');
            ?>
            
            <?php require_once "includes/footer.php"; ?>
        </div>
        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>