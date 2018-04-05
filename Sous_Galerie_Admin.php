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
$nomgalerie = $_GET['nom'];
$requete -> execute(array($nomgalerie));
$ligne = $requete -> fetch();
?> <!-- Peu judicieux mais necessaire pour afficher le pageTitle -->

<!doctype html>
<html>

    <?php 
    $pageTitle = $ligne['img_galerie'];
    require_once "includes/head.php"; 
    ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php";
            $requete = getDb() -> prepare("select * from image where img_galerie = ? and img_titre != ?");
            $sth = $ligne['img_galerie'];
            $requete -> execute(array($sth, $sth));
            $galerie = $requete -> fetchAll();
            $nbPages = ceil(count($galerie) / 12);
            ?>
            
            <br/>
            <section class="row">
                <div  class="col-xs-12 col-md-12">
                    <a href="Galerie_Admin.php">Galeries</a> / <?= $galerie[0][2] ?>
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
                                ?><a href="Sous_Galerie_Admin.php?nom=<?= $ligne['img_galerie'] ?>&page=<?= $i ?>" class="mot"><?= $i ?></a>
                            <?php }
                        }
                        ?>
                        | <a href="Sous_Galerie_Admin.php?nom=<?= $ligne['img_galerie'] ?>&page=999" class="mot">Tout voir</a>
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
                                <div>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/></div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="Modifier_Titre_Photo.php?nom=<?= $galerie[$i][1] ?>">Modifier le titre de la photo</a></li>
                                        <li><a href="Supprimer_Photo_Galerie.php?nom=<?= $galerie[$i][1]?>" onclick="return(confirm('Êtes-vous sûr(e) de vouloir effectuer cette action ?'));">Supprimer la photo</a></li>
                                    </ul>
                                </div>
                                <div class="photographe"><strong><?= $ligne['img_titre'] ?></strong></div>
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
                                <div>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div><img class="img-responsive image" src="<?= $galerie[$i][4] ?>" alt="Photo"/></div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="Modifier_Titre_Photo.php?nom=<?= $galerie[$i][1] ?>">Modifier le titre de la photo</a></li>
                                        <li><a href="Supprimer_Photo_Galerie.php?nom=<?= $galerie[$i][1]?>" onclick="return(confirm('Êtes-vous sûr(e) de vouloir effectuer cette action ?'));">Supprimer la photo</a></li>
                                    </ul>
                                </div>
                                <div class="photographe"><strong><?= $galerie[$i][1] ?></strong></div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </section><br/><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Ajout_Photo.php?nom=<?= $nomgalerie ?>" enctype="multipart/form-data">
                    <fieldset>
                        <legend class="mot">Ajouter une photo:</legend>
                        <label for="titre">Titre de la photo:</label><br/>
                        <input type="text" name="titre" id="titre" required/><br/><br/>
                        
                        <label for="ajoutimage">Selection de la photo: <em>(format jpg obligatoire)</em></label><br/>
                        <input type="text" name="ajoutimage" id="input_text_file" class="inputText" readonly="readonly"/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <input type="file" name="ajoutimage" onmousedown="return false" onkeydown="return false" class="inputFile" onchange="document.getElementById('input_text_file').value = this.value" /><br/>
                        
                        <label for="description">Desciption de la photo: <em>(facultatif)</em></label><br/>
                        <input type="text" name="description" id="description"/><br/><br/>
                        <input type="submit" value="Valider"/><br/><br/>
                    </fieldset>
                </form>
            </section>  

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>