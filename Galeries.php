<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <em>
                        <?php 
                        // selectionne tous les textes de présentation de l'onglet galerie
                        $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                        $onglet = "Galeries";
                        $requete -> execute(array($onglet));
                        $ligne = $requete -> fetch();
                        echo nl2br($ligne['txt_texte']);
                        ?>
                    </em>
                </div>
                <br/>
                <div>
                    <?php
                    $ligne = $requete -> fetch();
                    echo nl2br($ligne['txt_texte']);
                    ?>
                </div>
            </section><br/><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <?php if (isAdminConnected() || isFamillyConnected())
                    {
                        // si c'est l'admin ou une personne de la famille, on afiche toutes les photos
                        $requete = getDb() -> prepare("select * from image where img_titre = img_galerie");
                        $requete -> execute();
                        while($ligne = $requete -> fetch()) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div><a href="Sous_Galerie.php?nom=<?= $ligne['img_galerie'] ?>"><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/></a></div>
                                <div class="photographe"><strong><?= $ligne['img_galerie'] ?></strong></div>
                            </div>
                        <?php } 
                    }
                    else
                    {
                        //sinon on les affiche toutes sauf celles de la famille
                        $requete = getDb() -> prepare("select * from image where img_titre = img_galerie and img_titre != ?");
                        $secret = "Le monde des vivants";
                        $requete -> execute(array($secret));
                        while($ligne = $requete -> fetch()) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div><a href="Sous_Galerie.php?nom=<?= $ligne['img_galerie'] ?>&page=1"><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/></a></div>
                                <div class="photographe"><strong><?= $ligne['img_galerie'] ?></strong></div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </section><br/>
        
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>