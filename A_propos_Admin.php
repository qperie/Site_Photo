<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>
    
    <?php        
        for ($i=1; $i<=5; $i++)
        {
            $nom = 'message';
            $nom = $nom.$i;
            //si le message numéro i est modifié
            if (!empty($_POST[$nom]))
            {
                $texte = $_POST[$nom];
                $titre = 'A propos';
                $id = $i+1;
                //on enregistre les modifications dans la bdd
                $requete = getDb() -> prepare ("update texte set txt_texte= :texte where txt_titre = :titre and txt_id = :id");
                $requete -> bindValue('texte', $texte, PDO::PARAM_STR);
                $requete -> bindValue('titre', $titre, PDO::PARAM_STR);
                $requete -> bindValue('id', $id, PDO::PARAM_INT);
                $requete -> execute(); 
            }
        }
    ?>
    
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
                        //si le texte est bien enregistré, un message de succès s'affiche
                        if(isset($_POST['message1']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succès!</strong> La modification a bien été prise en compte
                            </div>
                        <?php
                        }
                        ?>
                        <form method="POST" action="A_propos_admin.php">
                            <textarea id="textarea" class="form-control" rows="6" name="message1" ><?php echo $ligne['txt_texte']?></textarea>
                            <input type="submit" value="Valider"/>
                        </form>
                    </div>
                </section>
            </div><br/><br/>
        
            <div class="row">
                <section class="col-xs-12 col-md-9">
                    <div><h4><u>A propos de l'auteur</u></h4></div>
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
                        <form method="POST" action="A_propos_admin.php">
                            <textarea id="textarea" class="form-control" rows="6" name="message2" ><?php echo $ligne['txt_texte']?></textarea>
                            <input type="submit" value="Valider"/>
                        </form>
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
                        if(isset($_POST['message3']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succés!</strong> La modification a bien étée prise en compte
                            </div>
                        <?php
                        }
                        ?>
                        <form method="POST" action="A_propos_admin.php">
                            <textarea id="textarea" class="form-control" rows="6" name="message3" ><?php echo $ligne['txt_texte']?></textarea>
                            <input type="submit" value="Valider"/>
                        </form>
                    </div>
                </section>
            </div>
        
            <div class="row">
                <section class="col-xs-12 col-md-7">
                    <div>
                        <?php
                        $ligne = $requete -> fetch();
                        if(isset($_POST['message4']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succés!</strong> La modification a bien étée prise en compte
                            </div>
                        <?php
                        }
                        ?>
                        <form method="POST" action="A_propos_admin.php">
                            <textarea id="textarea" class="form-control" rows="6" name="message4" ><?php echo $ligne['txt_texte']?></textarea>
                            <input type="submit" value="Valider"/>
                        </form>
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
                        if(isset($_POST['message5']))
                        {?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Succés!</strong> La modification a bien étée prise en compte
                            </div>
                        <?php
                        }
                        ?>
                        <form method="POST" action="A_propos_admin.php">
                            <textarea id="textarea" class="form-control" rows="6" name="message5" ><?php echo $ligne['txt_texte']?></textarea>
                            <input type="submit" value="Valider"/>
                        </form>
                    </div>
                </section>
            </div><br/><br/>

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>