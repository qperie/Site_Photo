<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?> <br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <?php 
                    // on selectionne tous les textes de description de l'onglet liens et on les affiches
                    $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                    $onglet = "Liens";
                    $requete -> execute(array($onglet));
                    $ligne = $requete -> fetch();
                    echo nl2br($ligne['txt_texte']);
                    ?>
                </div>
            </section>
        
            <section class="row">
                <?php
                // on selectionnes toutes les images des liens et on les affiches en faisant en sorte qu'ils soient cliquables et qu'il revoient vers une autre page internet
                $requete = getDb() -> prepare("select * from image where img_galerie = ?");
                $galerie = "Liens";
                $requete -> execute(array($galerie));
                while($ligne = $requete -> fetch()) { ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div><a href="<?= $ligne['img_description'] ?>"><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"></a></div>
                        <div class="photographe"><?= $ligne['img_titre'] ?></div>
                    </div>
                <?php } ?>
            </section><br/>
        
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>