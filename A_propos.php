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
            
            <div class="row">
                <section class="col-xs-12 col-md-2"><img class="img-responsive image" src="images/apropos1.jpg" alt="Photo" /></section>
                <section class="col-xs-12 col-md-10">
                    <div><h4><u>A propos de la photographie</u></h4></div>
                    <div><h5><em><strong>"Une photographie c'est un arrêt du coeur d'une fraction de seconde" (Pierre MOVILA)</strong></em></h5></div>
                    <div>
                        <?php 
                        // selectionne tous les textes de présentation de la partie A propos
                        $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                        $onglet = "A propos";
                        $requete -> execute(array($onglet));
                        $ligne = $requete -> fetch();
                        echo nl2br($ligne['txt_texte']);//fait en sorte de conservé les sauts de lignes
                        ?>
                    </div>
                </section>
            </div><br/><br/>
        
            <div class="row">
                <section class="col-xs-12 col-md-9">
                    <div><h4><u>A propos de l'auteur</u></h4></div>
                    <div>
                        <?php
                        $ligne = $requete -> fetch(); //affiche le texte au bon endroit
                        echo nl2br($ligne['txt_texte']);
                        ?>
                    </div>
                </section>
                
                <section class="col-xs-12 col-md-3"><img class="img-responsive image" src="images/apropos2.jpg" alt="Photo" /></section>
            </div><br/><br/>
        
            <div class="row">
                <section class="col-xs-12 col-md-12">
                    <div><h4><u>A propos du matériel</u></h4></div>
                    <div>
                        <?php
                        $ligne = $requete -> fetch();
                        echo nl2br($ligne['txt_texte']);
                        ?>
                    </div>
                </section>
            </div>
        
            <div class="row">
                <section class="col-xs-12 col-md-7">
                    <div>
                        <?php
                        $ligne = $requete -> fetch();
                        echo nl2br($ligne['txt_texte']);
                        ?>
                    </div>
                </section>
                <section class="col-xs-12 col-md-4"><img class="img-responsive image" src="images/apropos3.jpg" alt="Photo" /></section>
            </div><br/><br/>
        
            <div class="row">
                <section class="col-xs-12 col-md-12">
                    <div><h4><u>A propos des images de ce site</u></h4></div>
                    <div>
                        <?php
                        $ligne = $requete -> fetch();
                        echo nl2br($ligne['txt_texte']);
                        ?>
                    </div>
                </section>
            </div><br/><br/>

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>