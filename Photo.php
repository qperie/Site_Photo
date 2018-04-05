<?php
require_once "includes/functions.php";
session_start();

$requete = getDb() -> prepare("select * from image where img_id = ?");
$photo = $_GET['id'];
$requete -> execute(array($photo));
$ligne = $requete -> fetch();
?> <!-- Peu judicieux mais nécessaire pour afficher le pageTitle -->

<!doctype html>
<html>

    <?php 
    $pageTitle = $ligne['img_titre'];
    require_once "includes/head.php"; 
    ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?>
            
            <br/>
            <section class="row" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div>
                    <a href="Galeries.php">Galeries</a> / <a href="Sous_Galerie.php?nom=<?= $ligne['img_galerie'] ?>"><?= $ligne['img_galerie'] ?></a> / <?= $ligne['img_titre'] ?>
                </div>
            </section>
            
            <section class="row" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></section>
            
            <div class="row" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                //selectionne toutes les images de la galerie dont le titre est différent du titre de la galerie
                $requete = getDb() -> prepare("select * from image where img_galerie = ? and img_titre != ?");
                $sth = $ligne['img_galerie'];
                $requete -> execute(array($sth, $sth));
                $galerie = $requete -> fetchAll();
                
                for ($i = 0; $i < count($galerie); $i++)
                {
                    if ($galerie[$i][0] == $_GET['id'])
                    {
                        $ligne = $i;
                    }
                }
                
                if ($ligne == 0) { ?>
                    <section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a href="Photo.php?id=<?= $galerie[count($galerie) - 1][0] ?>"><img src="images/arrow-left.png" alt="Flèche" class="img-responsive"></a></section>
                <?php } else { ?>
                    <section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a href="Photo.php?id=<?= $galerie[$ligne - 1][0] ?>"><img src="images/arrow-left.png" alt="Flèche" class="img-responsive"/></a></section>
                <?php } ?>        
                
                <section class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <div>
                        <a href=""><img class="img-responsive image" src="<?= $galerie[$ligne][4] ?>" alt="Photo"></a>
                    </div><br/>
                    <div class="photographe">
                        <strong><?= $galerie[$ligne][1]; ?></strong><br/>
                        <?= $galerie[$ligne][3]; ?>
                    </div>
                </section>
                <?php if ($ligne == count($galerie) - 1) { ?>
                    <section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a href="Photo.php?id=<?= $galerie[0][0] ?>"><img src="images/arrow-right.png" alt="Flèche" class="img-responsive"/></a></section>
                <?php } else { ?>
                    <section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a href="Photo.php?id=<?= $galerie[$ligne + 1][0] ?>"><img src="images/arrow-right.png" alt="Flèche" class="img-responsive"></a></section>
                <?php } ?>
                        
                
            </div><br/><br/>

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>