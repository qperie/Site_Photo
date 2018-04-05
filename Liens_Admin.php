<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <?php
        $nom = 'message';
        if (!empty($_POST[$nom]))
        {
            $texte = $_POST[$nom];
            $titre = 'Liens';
            $id = 9;
            $requete = getDb() -> prepare ("update texte set txt_texte= :texte where txt_titre =:titre and txt_id=:id");
            $requete -> bindValue('texte', $texte, PDO::PARAM_STR);
            $requete -> bindValue('titre', $titre, PDO::PARAM_STR);
            $requete -> bindValue('id', $id, PDO::PARAM_INT);
            $requete -> execute(); //met à jour dans la bdd le texte de présentation de la page liens                
        }
    ?>
    
    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?> <br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <em>
                        <?php 
                        //on selectionne tous les textes de présentation de l'onglet liens pour qu'il s'affichent dans un textarea
                        $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                        $onglet = "Liens";
                        $requete -> execute(array($onglet));
                        $ligne = $requete -> fetch();
                        //si les modifs ont étés faites, on affiche un message de succès
                        if(isset($_POST['message']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succès!</strong> La modification a bien été prise en compte
                            </div>
                        <?php
                        }
                        ?>
                    </em>
                    <form method="POST" action="Liens_Admin.php">
                        <textarea id="textarea" class="form-control" rows="3" name="message" ><?php echo $ligne['txt_texte']?></textarea>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
            </section><br/><br/>
        
            <section class="row">
                <?php
                //on selectionne toues les images, on les affiches et on fait en sorte qu'elles soient clicables et qu'on menu déroulant s'affiche
                $requete = getDb() -> prepare("select * from image where img_galerie = ?");
                $galerie = "Liens";
                $requete -> execute(array($galerie));
                while($ligne = $requete -> fetch()) { ?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/></div>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="Modifier_Lien.php?lien=<?= $ligne['img_description'] ?>">Modifier l'adresse du site</a></li>
                                <li><a href="Supprimer_Lien.php?nom=<?= $ligne['img_titre'] ?>" onclick="return(confirm('Êtes-vous sûr(e) de vouloir effectuer cette action ?'));">Supprimer ce lien</a></li>
                            </ul>
                        </div>
                        <div class="photographe"><?= $ligne['img_titre'] ?></div>
                    </div>
                <?php } ?>
            </section><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Ajout_Lien.php" enctype="multipart/form-data">
                    <fieldset>
                        <legend class="mot">Ajouter un lien :</legend>
                        
                        <label for="titre">Nom du photographe:</label><br/>
                        <input type="text" name="titre" id="titre" required/><br/><br/>
                        
                        <label for="ajoutlien">Adresse du site :</label><br/>
                        <input type="text" name="ajoutlien" id="ajoutlien" required/><br/><br/>
                        
                        <label for="ajoutimage">Attribuer une photo au lien : <em>(format jpg obligatoire)</em></label><br/>
                        <input type="text" name="ajoutimage" id="input_text_file" class="inputText" readonly="readonly"/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <input type="file" name="ajoutimage" onmousedown="return false" onkeydown="return false" class="inputFile" onchange="document.getElementById('input_text_file').value = this.value" /><br/><br/>
                        <input type="submit" value="Valider"/><br/><br/>
                                                
                    </fieldset>
                </form>
            </section>
        
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>