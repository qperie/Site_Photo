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
            
            // si l'admin a bien entré un nom pour sa galerie et donné son image
                if(!empty($_POST['nomgalerie']) & !empty($_FILES['ajoutimage']))
                {
                    //et que le transfert ,'a pas bien été effectué ou que le fichié est trop gros
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

                    $galerie=$_POST['nomgalerie'];
                    $titre = $_FILES['ajoutimage']['name'];
                    $titreexpention=$titre;//ici il reste l'expention avec le titre
                    
                    //on récupère seulement le titre de l'image sans l'extantion
                    $titre = explode(".", $titre);
                    $nb = count($titre);
                    $titreimage="";
                    for($i=0; $i<$nb-1;$i++)
                    {
                        $titreimage=$titreimage.$titre[$i];
                    }
                    
                    //ici il aurait fallu pouvoir transformer les caractères accentués en non accentués mais ce n'est pas fonctionnel
                    //$titreadresse = strtr( $titre,'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝáàâäãåçéèêëíìîïñóòôöõúùûüýÿ','AAAAAACEEEEEIIIINOOOOOUUUUYaaaaaaceeeeiiiinooooouuuuyy' );
                    $adresse ="images/".$galerie."/";
                    $adresseimage=$adresse.$titreexpention;
                    
                    //crée une nouvelle ligne dans la bdd contenant les information de l'image
                    $requete = getDb() -> prepare("insert into image (img_titre, img_galerie, img_description, img_adresse) values (:titre, :galerie, :description, :adresse)");
                    $requete -> bindValue('titre', $titreimage, PDO::PARAM_STR);
                    $requete -> bindValue('galerie', $galerie, PDO::PARAM_STR);
                    $requete -> bindValue('description', $desc, PDO::PARAM_STR);
                    $requete -> bindValue('adresse', $adresseimage, PDO::PARAM_STR);
                    $requete -> execute();
                    
                    //ajoute l'image dans la bdd en tant qu'image de presentation de la galerie
                    $requete = getDb() -> prepare("insert into image (img_titre, img_galerie, img_adresse) values (:titre, :galerie, :adresse)");
                    $requete -> bindValue('titre', $galerie, PDO::PARAM_STR);
                    $requete -> bindValue('galerie', $galerie, PDO::PARAM_STR);
                    $requete -> bindValue('adresse', $adresseimage, PDO::PARAM_STR);//crée une nouvelle ligne dans la bdd contenant les information de l'image
                    $requete -> execute();
                    
                    
                    //cree nouv dossier avec l'image dedans
                    mkdir($adresse, 0700);
                    $resultat = move_uploaded_file($_FILES['ajoutimage']['tmp_name'],$adresseimage);
                    
                }
                redirect("Galerie_Admin.php");
            ?>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>