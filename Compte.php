<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?> <br/><br/>
        
            <section class="row">
            <div class="col-xs-12 col-md-offset-4 col-md-4">
                <?php
                
                if (array_key_exists('login', $_POST))
                {
                    // si l'utilisateur a rempli son login
                    if ($_POST['login'] != null)
                    {
                        //on enregitre les modifications dans la bdd
                        $requete = getDb() -> prepare("update compte set compte_login = :nouvlog where compte_login = :ancienlog");
                        $ancien = $_SESSION['login'];
                        $nouveau = $_POST['login'];
                        $requete -> bindValue('nouvlog', $nouveau, PDO::PARAM_STR);
                        $requete -> bindValue('ancienlog', $ancien, PDO::PARAM_STR);
                        $requete -> execute();
                        $_SESSION['login']=$_POST['login'];
                    }
                    
                    //si l'utilisateur a rempli son mot de passe 
                    if ($_POST['mdp'] != null)
                    {
                        //on le change dans la bdd
                        $requete = getDb() -> prepare("update compte set compte_mdp = :nouvmdp where compte_login = :log");
                        $login = $_SESSION['login'];
                        $nouveau = $_POST['mdp'];
                        $requete -> bindValue('nouvmdp', $nouveau, PDO::PARAM_STR);
                        $requete -> bindValue('log', $login, PDO::PARAM_STR);
                        $requete -> execute();
                        $_SESSION['mdp']=$_POST['login'];
                    }
                    //si l'utilisateur  a changé son mail
                    if ($_POST['mail'] != null)
                    {
                        $requete = getDb() -> prepare("update compte set compte_mail = :nouvmail where compte_login = :log");
                        $login = $_SESSION['login'];
                        $nouveau = $_POST['mail'];
                        $requete -> bindValue('nouvmail', $nouveau, PDO::PARAM_STR);
                        $requete -> bindValue('log', $login, PDO::PARAM_STR);
                        $requete -> execute();
                        $_SESSION['mail']=$_POST['mail'];
                    }
                    redirect('Accueil.php');
                }
                else
                { ?>
                    <form method="POST" action="Compte.php">
                        <fieldset>
                          <div>
                            <label for='login'>Modifier votre login :</label><br/>
                            <input type='text' name='login' size ='60%'/>
                            </div><br/><br/>
                          <div>
                            <label for='mdp'>Modifier votre mot de passe :</label><br/>
                            <input type='password' name='mdp' size ='60%'/>
                          </div><br/><br/>
                          <div>
                            <label for='mail'>Modifier l'adresse mail :</label><br/>
                            <input type='email' name='mail' size ='60%'/>
                          </div><br/><br/>
                          <div>
                            <button class="btn-group btn-group-justified btn btn-primary" type="submit">Envoyer</button><br/>
                          </div>
                        </fieldset>
                    </form><br/><br/>
                <?php } ?>
            </div>
            </section>
        
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>