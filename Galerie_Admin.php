<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>
    
    <?php
    //pour chaque texte de présentation d la galerie
        for ($i=1; $i<=2; $i++)
        {
            $nom = 'message';
            $nom = $nom.$i;
            //si il a été modifié
            if (!empty($_POST[$nom]))
            {
                $texte = $_POST[$nom];
                $titre = 'Galeries';
                $id = $i+6;
                //on le met à jour dans la bdd
                $requete = getDb() -> prepare ("update texte set txt_texte= :texte where txt_titre =:titre and txt_id=:id");
                $requete -> bindValue('texte', $texte, PDO::PARAM_STR);
                $requete -> bindValue('titre', $titre, PDO::PARAM_STR);
                $requete -> bindValue('id', $id, PDO::PARAM_INT);
                $requete -> execute();               
            }   
        }
    ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <em>
                        <?php 
                        // on selectionne tous les textes de présentation de l'onglet galerie pour les afficher dans des textarea
                        $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                        $onglet = "Galeries";
                        $requete -> execute(array($onglet));
                        $ligne = $requete -> fetch();
                        if(isset($_POST['message1']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succès!</strong> La modification a bien été prise en compte
                            </div>
                        <?php
                        }
                        ?>
                    </em>
                    <form method="POST" action="Galerie_Admin.php">
                        <textarea id="textarea" class="form-control" rows="3" name="message1" ><?php echo $ligne['txt_texte']?></textarea>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
                <br/>
                <div>
                    <?php
                    $ligne = $requete -> fetch();
                    if(isset($_POST['message2']))
                    {?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Succès!</strong> La modification a bien été prise en compte
                         </div>
                    <?php
                    }
                    ?>
                    <form method="POST" action="Galerie_Admin.php">
                        <textarea id="textarea" class="form-control" rows="3" name="message2" ><?php echo $ligne['txt_texte']?></textarea>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
            </section><br/><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <div>
                    <?php 
                    // on selectionne toutes les images de présentation des galeries pour les afficher et faire en sorte qu'elles soient clicables et qu'elles affiche un menu déroulant
                        $requete = getDb() -> prepare("select * from image where img_titre = img_galerie");
                        $requete -> execute();
                        while($ligne = $requete -> fetch()) { ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                <div>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div><img class="img-responsive image" src="<?= $ligne['img_adresse'] ?>" alt="Photo"/></div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="Sous_Galerie_Admin.php?nom=<?= $ligne['img_galerie'] ?>">Visiter la galerie/La modifier</a></li>
                                        <li><a href="Modifier_Titre_Galerie.php?nom=<?= $ligne['img_galerie'] ?>">Modifier le titre de la galerie</a></li>
                                        <li><a href="Supprimer_Galerie.php?nom=<?= $ligne['img_galerie'] ?>" onclick="return(confirm('Êtes-vous sûr(e) de vouloir effectuer cette action ?'));">Supprimer Galerie</a></li>
                                    </ul>
                                </div>
                                <div class="photographe"><strong><?= $ligne['img_galerie'] ?></strong></div>
                            </div>
                    <?php }
                    ?>
                </div>
            </section><br/>
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Ajout_Galerie.php" enctype="multipart/form-data">
                    <fieldset>
                        <legend class="mot">Ajouter une galerie:</legend>
                        <label for="nomgalerie">Titre de la galerie:</label><br/>
                        <input type="text" name="nomgalerie" id="nomgalerie" required/><br/><br/>
                        
                        <label for="ajoutimage">Attribuer une photo à  la galerie: <em>(format jpg obligatoire)</em></label><br/>
                        <input type="text" name="ajoutimage" id="input_text_file" readonly="readonly"/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <input type="file" name="ajoutimage" onmousedown="return false" onkeydown="return false" class="inputFile" onchange="document.getElementById('input_text_file').value = this.value" /><br/>
                        
                        <label for="description">Desciption de l'image: <em>(facultatif)</em></label><br/>
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