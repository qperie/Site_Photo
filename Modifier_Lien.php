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
           
                if (!empty($_POST['liensite']))
                {                    
                    $liennouv=$_POST['liensite'];
                    $lienancien = $_POST['ancienlien'];
                    
                    //change l'adresse de destination du lien dans l'image
                    $requete = getDb() -> prepare ("update image set img_description=:liennouv where img_description=:lienancien");
                    $requete -> bindValue('liennouv', $liennouv, PDO::PARAM_STR);
                    $requete -> bindValue('lienancien', $lienancien, PDO::PARAM_STR);
                    $requete -> execute();
                    redirect("Liens_Admin.php");
                }
            
            ?>
            
            <section class="row" class="col-xs-12 col-md-12">
                <form method="POST" action="Modifier_Lien.php">
                    <fieldset>
                        <legend class="mot">Modifier le lien du site :</legend>
                        <label for="ancienlien">Ancien lien du site :</label><br>
                        <textarea id="ancienlien" class="form-control" name="ancienlien" readonly="readonly"><?= $_GET['lien'] ?></textarea><br/>
                        <label for="liensite">Nouveau lien du site :</label><br/>
                        <input type="text" name="liensite" id="liensite" required/><br/><br/>
                        <button class="btn btn-primary" type="submit">Valider</button>
                        <button class="btn btn-primary" onclick="location.href='Liens_Admin.php'">Annuler</button><br/><br/>
                    </fieldset>
                </form>
            </section>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>