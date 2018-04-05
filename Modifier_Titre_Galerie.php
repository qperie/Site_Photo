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
            
            <?php
                if (!empty($_POST['nomgalerie']))
                {
                    $titrenouv=$_POST['nomgalerie'];
                    $titreancien = $_POST['anciennom'];
                    
                    //Modifie le nom du dossier dans le dossier image du site
                    $adresseancienne = "";
                    $adressenouv = "";
                    $adresseancienne = $adresseancienne."images/".$titreancien."/";
                    $adressenouv = $adressenouv."images/".$titrenouv."/.";
                    rename ($adresseancienne, $adressenouv);
                    
                    //change le nom de la galerie pour tte les images de la galerie
                    $requete = getDb() -> prepare ("update image set img_galerie=:titrenouv where img_galerie=:titreancien");
                    $requete -> bindValue('titrenouv', $titrenouv, PDO::PARAM_STR);
                    $requete -> bindValue('titreancien', $titreancien, PDO::PARAM_STR);
                    $requete -> execute();
                
                    //change le nom de la photo representant la galerie
                    $requete2 = getDb() -> prepare("update image set img_titre=:titrenouv where img_titre=:titreancien");
                    $requete2 -> bindValue('titrenouv', $titrenouv, PDO::PARAM_STR);
                    $requete2 -> bindValue('titreancien', $titreancien, PDO::PARAM_STR);
                    $requete2 -> execute();
                    redirect("Galerie_Admin.php");
                }
            ?>
            
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Modifier_Titre_Galerie.php">
                    <fieldset>
                        <legend class="mot">Modifier le titre de la galerie:</legend>
                        <label for="anciennom">Ancien titre de la galerie:</label><br>
                        <input type="text" name="anciennom" id="anciennom" value="<?php echo $_GET['nom'] ?>" readonly="readonly" class="input"/><br/>
                        <label for="nomgalerie">Nouveau titre de la galerie:</label><br/>
                        <input type="text" name="nomgalerie" id="nomgalerie" required/><br/><br/>
                        <button class="btn btn-primary" type="submit">Valider</button>
                        <button class="btn btn-primary" onclick="location.href='Galerie_Admin.php'">Annuler</button><br/><br/>
                    </fieldset>
                </form>
            </section>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>