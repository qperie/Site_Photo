<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>
    
<?php 
$pageTitle = "Inscription";
require_once "includes/head.php";
?>

    <?php require_once "includes/head.php"; ?>
    
    <?php
    // si tous les parametres ont étés rempli
    if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['mail']))
    {
        
        $login=$_POST['login'];
        $mdp=$_POST['password'];
        $mail= $_POST['mail'];
        
        //selectione les logins qui seraient potentielement égaux à celui entré
        $requete = getDb() -> prepare ("select * from compte where compte_login=?");
        $requete -> execute (array($login));
        $ligne = $requete -> fetch();
        $nb=$requete->rowCount();
        
        //si login déjà pris, il doit en choir un autre
        if ($nb>0)
        {?>
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Erreur!</strong> Votre login est déjà pris, veuillez en choisir un autre
                </div>
            </div>
        <?php }
        //sinon on l'enregistre
        if($nb==0)
        {
            $requete2 = getDb() -> prepare("insert into compte (compte_login, compte_mdp, compte_mail, compte_statu) values (:login, :mdp, :mail, :statu)");
            $statu="public";
            $requete2 -> bindValue('login', $login, PDO::PARAM_STR);
            $requete2 -> bindValue('mdp', $mdp, PDO::PARAM_STR);
            $requete2 -> bindValue('mail', $mail, PDO::PARAM_STR);
            $requete2 -> bindValue('statu', $statu, PDO::PARAM_STR);
            $requete2 -> execute();
            ?>
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Succès!</strong> La modification a bien été prise en compte
                </div>
            </div>
        <?php }
    }
    ?>
    
    
    
    <body>
        <div class="container">
            
            <?php require_once "includes/header.php"; ?>
            <h2 class="text-center"><?= $pageTitle ?></h2>
            
            
            <form class="form-signin form-horizontal" role="form" action="Inscription.php" method="post">
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <input type="email" name="mail" class="form-control" placeholder="Entrez votre adresse mail" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <div class="photographe">
                            <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> S'inscrire</button>
                        </div>
                    </div>
                </div>
            </form><br/>
            
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>