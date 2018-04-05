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
            // si l'admin a bien envoyé un fichier
                if(!empty($_FILES['ajoutimage']))
                {
                    //si il y a eu une erreur lors du transfert ou que la taille de l'image est trop grande
                    if ($_FILES['ajoutimage']['error'] > 0) $erreur = "Erreur lors du transfert";
                    else if ($_FILES['ajoutimage']['size'] > 1000000) $erreur = "Le fichier est trop gros";
                    
                    //Si il a entré une description on la stocke dans une variable
                    if(!empty($_POST['description']))
                    {
                        $desc=$_POST['description'];
                        echo $desc;
                    }
                    //sinon on met rien dans la variable
                    else {$desc="";}
                    
                    $galerie = $_GET['nom'];
                    
                    $nom = $_POST['titre'];
                    $adresse = "images/".$galerie."/".$nom.".jpg"; //fixe l'adresse ou l'image est stockee
                    $image = $_FILES['ajoutimage'];
                    $resultat = move_uploaded_file($_FILES['ajoutimage']['tmp_name'],$adresse); //déplace dans le fichier image du site au bon endroit l'image téléchargée
                    
                    // rajoute l'image dans mes fichiers du site
                    $requete = getDb() -> prepare("insert into image (img_titre, img_galerie, img_description, img_adresse) values (:titre, :galerie, :description, :adresse)");
                    $requete -> bindValue('titre', $nom, PDO::PARAM_STR);
                    $requete -> bindValue('galerie', $galerie, PDO::PARAM_STR);
                    $requete -> bindValue('description', $desc, PDO::PARAM_STR);
                    $requete -> bindValue('adresse', $adresse, PDO::PARAM_STR);//crée une nouvelle ligne dans la bdd contenant les information de l'image
                    $requete -> execute();
                }
                redirect("Sous_Galerie_Admin.php?nom=$galerie");
            ?>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>