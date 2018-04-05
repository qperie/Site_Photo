<?php
require_once "includes/functions.php";
session_start();

if (isset($_GET['page']))
{
    $page = $_GET['page'];    
}
else
{
    $page = 1;
}
$requete = getDb() -> prepare("select * from image where img_galerie = ?");
$galerie = $_GET['nom'];
$requete -> execute(array($galerie));
$ligne = $requete -> fetch();
?> <!-- Peu judicieux mais nécessaire pour afficher le pageTitle -->

<!doctype html>
<html>

    <?php 
    $pageTitle = $ligne['img_galerie'];
    require_once "includes/head.php"; 
    ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php";
            
            //selectionne toutes les images d'une galerie en particulier
            $requete = getDb() -> prepare("select * from image where img_galerie = ?  and img_titre != ?");
            $sth = $ligne['img_galerie'];
            $requete -> execute(array($sth, $sth));
            $galerie = $requete -> fetchAll();
            $nbPages = ceil(count($galerie) / 12);
            ?>
            
            <br/>
            <section class="row">
                <div  class="col-xs-12 col-md-12">
                    <a href="Galeries.php">Galeries</a> / <?= $galerie[0][2] ?>
                </div>
            </section>
            
            <section class="row">
                <div class="col-xs-12 col-md-12">
                    <h4 class="photographe"><u>Page</u> :
                        <?php
                        for ($i = 1; $i < $nbPages + 1; $i++)
                        {
                            if($i == $page)
                            {
                                echo(" ");
                                ?><u class="mot"><?= $i ?></u>
                            <?php }
                            else
                            {
                                echo(" ");
                                ?><a href="Sous_Galerie.php?nom=<?= $ligne['img_galerie'] ?>&page=<?= $i ?>" class="mot"><?= $i ?></a>
                            <?php }
                        }
                        ?>
                        | <a href="Sous_Galerie.php?nom=<?= $ligne['img_galerie'] ?>&page=999" class="mot">Tout voir</a>
                    </h4>
                </div>
            </section>
            
            <section class="row">
                <div class="col-xs-12 col-md-12">
                    <?php
                    if ($page == 999)
                    {
                        $requete = getDb() -> prepare("select * from image where img_galerie = ? and img_titre != ?");
                        $galerie = $_GET['nom'];
                        $requete -> execute(array($galerie, $galerie));
                        while($ligne = $requete -> fetch()) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="Photo.php?id=<?= $ligne['img_id'] ?>"><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"></a>
                            </div>
                        <?php } 
                    }
                    else
                    {
                        $requete = getDb() -> prepare("select * from image where img_galerie = ? and img_titre != ?");
                        $galerie = $_GET['nom'];
                        $requete -> execute(array($sth, $sth));
                        $galerie = $requete -> fetchAll();
                        if ($page * 12 > count($galerie))
                        {
                            $min = ($page - 1) * 12;
                            $max = count($galerie);
                        }
                        else
                        {
                            $min = ($page - 1) * 12;
                            $max = $page * 12;
                        }
                        for ($i = $min; $i < $max; $i++) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="Photo.php?id=<?= $galerie[$i][0] ?>"><img class="img-responsive image" src="<?= $galerie[$i][4] ?>" alt="Photo"></a>
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