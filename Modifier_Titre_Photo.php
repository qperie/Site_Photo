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
                if (!empty($_POST['nomphoto']))
                {
                    $titrenouv=$_POST['nomphoto'];
                    $titreancien = $_POST['anciennom'];
                    
                    //Modifie le nom du dossier dans le dossier image du site
                    $requete2 = getDb() -> prepare("select * from image where img_titre=?");
                    $requete2 -> execute(array($titreancien));
                    $ligne = $requete2 -> fetch();
                    $adresseancienne = "";
                    $adressenouv = "";
                    $adresseancienne = $ligne['img_adresse'];
                    $adressenouv = $adressenouv."images/".$ligne['img_galerie']."/".$titrenouv.".jpg";
                    
                    rename ($adresseancienne, $adressenouv);
                    
                    //change le nom de la photo
                    $requete = getDb() -> prepare ("update image set img_titre=:titrenouv where img_titre=:titreancien");
                    $requete -> bindValue('titrenouv', $titrenouv, PDO::PARAM_STR);
                    $requete -> bindValue('titreancien', $titreancien, PDO::PARAM_STR);
                    $requete -> execute();
                    
                    $galerie=$ligne['img_galerie'];
                    redirect("http://localhost/Progweb/projetweb-docteur-perie/Sous_Galerie_Admin.php?nom=$galerie");
                }
            ?>
            
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Modifier_Titre_Photo.php">
                    <fieldset>
                        <legend class='mot'>Modifier le titre de la photo:</legend>
                        <label for="anciennom">Ancien titre de la photo:</label><br>
                        <input type="text" name="nomphoto" id="nomphoto" readonly="readonly" class="input" value="<?php echo $_GET['nom'] ?>"/><br/><br/>
                        <label for="nomphotoe">Nouveau titre de la photo:</label><br/>
                        <input type="text" name="nomphoto" id="nomphoto" required/><br/>
                        <input type="submit" value="Valider"/>
                    </fieldset>
                </form>
            </section><br/>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>