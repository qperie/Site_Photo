<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?>
            
            <section class="row">
                <script>
                    <?php 
                    //selectionne les informations des photos qui doivent apparaitre dans le diapo
                    $requete = getDb() -> prepare("select * from image where img_galerie=?");
                    $galerie = 'Accueil';
                    $requete -> execute (array($galerie));
                    ?>
                    var Images = new Array(<?php 
                        while($ligne = $requete->fetch())
                        {echo "'".$ligne['img_adresse']."',";} ?> ) //Images que l'on veut faire defiler
                    var Pointeur = 0;

                    function imageSuivante() //fait apparaitre la photo suivante dans la liste
                    {
                        var img = document.getElementById("img");
                        img.src = Images[Pointeur];

                        Pointeur++;
                        if(Pointeur == Images.length)
                        {
                            Pointeur = 0;
                        }
                    }

                    window.setInterval(imageSuivante, 3000);//determine le temps entre chaque changement de photo
                </script>

                <?php 
                //selectionne les informations des photos qui doivent apparaitre dans le diapo
                    $requete = getDb() -> prepare("select * from image where img_galerie=?");
                    $galerie = 'Accueil';
                    $requete -> execute (array($galerie));
                    $ligne = $requete->fetch()
                ?>
                <div onload='imageSuivante()' class="diaporama col-xs-12 col-md-12">
                    <img class="img-responsive image" id='img' src='<?php echo $ligne['img_adresse']  ?>' />
                </div>
            </section>
            
            <section class="row">
                <div class="texte">
                    <?php 
                        //selectionne le texte de présentation de la page d'accueil et l'afiche
                    $requete = getDb() -> prepare("select txt_texte from texte where txt_titre = ?");
                    $onglet = "Accueil";
                    $requete -> execute(array($onglet));
                    $ligne = $requete -> fetch();
                    echo nl2br($ligne['txt_texte']);
                    ?>
                </div>
            </section>

            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>