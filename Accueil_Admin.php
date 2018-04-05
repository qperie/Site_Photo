<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>
    
    <?php
    //si l'admin a rempli le formulaire d'ajout image
            if (!empty($_FILES['ajoutimage']))
            {
                //et si le telechargement a été correctement effectué et que la taille de l'image n'est pas trop grande
                if ($_FILES['ajoutimage']['error'] > 0) $erreur = "Erreur lors du transfert";
                else if ($_FILES['ajoutimage']['size'] > 1000000) $erreur = "Le fichier est trop gros";
                
                //alors on selectionne toutes les images du diapo pour obtenir la dernière en date
                $requete = getDb()-> prepare("select * from image where img_titre like 'diapo%' order by img_titre DESC");
                $requete -> execute();
                $ligne = $requete -> fetch();
                //on prend le nom de la dernière qui est de la forme diapo+chiffre
                $nom = $ligne['img_titre'];
                $nom = intval(preg_replace('`[^0-9]`', '', $nom));// preg_replace ne garde que les chiffres du nom et intval trasforme le tout en int
                $nom = $nom+1;
                $nom = "diapo".$nom; //donne le titre de l'image avec le chiffre d'aprés
                $adresse = "images/Accueil/".$nom.".jpg"; //fixe l'adresse ou l'image est stockee
                
                $image = $_FILES['ajoutimage'];
                $resultat = move_uploaded_file($_FILES['ajoutimage']['tmp_name'],$adresse);//déplace l'image téléchargé dans le dossier image de notre site
                
                //on ajoute à la bdd les informations de l'image téléchargée
                $requete = getDb() -> prepare("insert into image (img_titre, img_galerie, img_adresse) values (:titre, :galerie, :adresse)");
                $galerie ="Accueil";
                $requete -> bindValue('titre', $nom, PDO::PARAM_STR);
                $requete -> bindValue('galerie', $galerie, PDO::PARAM_STR);
                $requete -> bindValue('adresse', $adresse, PDO::PARAM_STR);//crée une nouvelle ligne dans la bdd contenant les information de l'image
                $requete -> execute();
            }
    //si l'admin a changé le texte de présentation
            if (!empty($_POST['message']))
            {
                $texte = $_POST['message'];
                $titre = 'Accueil';
                //on met le texte à jour dans la bdd
                $requete = getDb() -> prepare ("update texte set txt_texte= :texte where txt_titre =:titre");
                $requete -> bindValue('texte', $texte, PDO::PARAM_STR);
                $requete -> bindValue('titre', $titre, PDO::PARAM_STR);
                $requete -> execute(); //met à jour dans la bdd le texte de présentation de la page d'accueil
            }
            ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <?php
                    // selectionne toutes les infos des images qui deffilent dans le diapo de la page d'accueil
                    $requete = getDb() -> prepare("select * from image where img_galerie = 'Accueil'");
                    $requete -> execute();
                    //pour chacune d'elles ont fait en sorte d'afficher leur nom, qu'elles soient cliquables et qu'une barre déroulente permete de les supprimer
                    while($ligne = $requete -> fetch()) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <div>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="Supprimer_photo.php?nom=<?= $ligne['img_titre']?>" onclick="return(confirm('Êtes-vous sûr(e) de vouloir effectuer cette action ?'));">Supprimer</a></li>
                                </ul>   
                            </div>
                            <div class="photographe"><strong><?= $ligne['img_titre'] ?></strong></div>
                        </div>
                    <?php } ?>
                </div>
            </section><br/><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Accueil_Admin.php" enctype="multipart/form-data">
                    <fieldset>
                        <label for="ajoutimage">Ajouter une image: (format jpg obligatoire)</label><br/>
                        <input type="text" name="ajoutimage" id="input_text_file" class="inputText" readonly="readonly"/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <input type="file" name="ajoutimage" onmousedown="return false" onkeydown="return false" class="inputFile" onchange="document.getElementById('input_text_file').value = this.value" />
                        <input type="submit" value="Valider"/>
                    </fieldset><br/>
                </form>
                <form method="POST" action="Accueil_Admin.php">
                    <fieldset>
                        <label for="modiftexte">Modifier le texte de présentation:</label><br/>
                        <?php 
                        //selectionne le texte que l'admin pourra voir dans le textarea et qu'il poura modifier
                            $requete = getDb() -> prepare ( "select * from texte where txt_titre='Accueil'");
                            $requete -> execute();
                            $ligne = $requete -> fetch();
                        ?>
                        <textarea id="textarea" class="form-control" rows="6" name="message" ><?php echo $ligne['txt_texte']?></textarea>
                        <input type="submit" value="Valider"/>
                    </fieldset>
                </form>
            </section><br/><br/>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>
        
        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>