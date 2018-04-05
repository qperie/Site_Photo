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
            if(!empty($_POST['secret']))
            {
                $statu = 'public';
                $login = $_POST['login'];
                $requete = getDb() -> prepare("update compte set compte_statu=:statu where compte_login=:login");
                $requete -> bindValue('statu', $statu, PDO::PARAM_STR);
                $requete -> bindValue('login', $login, PDO::PARAM_STR);
                $requete -> execute();
                unset($_POST['secret']);
                unset($_POST['public']);
            }
            if(!empty($_POST['public']))
            {
                $statu = 'secret';
                $login = $_POST['login'];
                $requete = getDb() -> prepare("update compte set compte_statu=:statu where compte_login=:login");
                $requete -> bindValue('statu', $statu, PDO::PARAM_STR);
                $requete -> bindValue('login', $login, PDO::PARAM_STR);
                $requete -> execute();
                unset($_POST['public']);
                unset($_POST['secret']);
            }
            ?>
            
            <section class="row" class="col-xs-12 col-md-12">
                <?php
                //selectionne tous les comptes dont le status est secret
                $requete1 = getDb() -> prepare("select * from compte where compte_statu='secret'");
                $requete1 -> execute();
                //selectionne tous les comptes dont le status est public
                $requete2 = getDb() -> prepare ("select * from compte where compte_statu='public'");
                $requete2 -> execute(); ?>
                 
                <table class="table table-bordered table-condensed table-responsive">
                    <tr>
                        <th>Login:</th><th>Mail:</th><th>Statuts:</th><th>Changer le statut:</th>
                    </tr>
                    <?php
                    //affiche dans un tableau la liste des personnes ayant la statut secret avec un bouton pour leuer changer de statut
                    while ($ligne1 = $requete1 -> fetch())
                    {?>
                        <tr>
                            <form method="POST" action="Liste_Famille.php">
                                <td><input type="text" name="login" id="login" readonly="readonly" class="input" value="<?= $ligne1['compte_login'] ?>"/></td>
                                <td><?= $ligne1['compte_mail'] ?></td>
                                <td><input type="text" name="secret" id="secret" readonly="readonly" class="input" value="<?= $ligne1['compte_statu'] ?>"/></td>
                                <td><input type="submit" value="Changer le statut à 'public'"/></td>
                            </form>
                        </tr>
                    <?php }
                    //affiche dans un tableau la liste des personnes ayant le status public avec un bouton pour leuer changer de statut
                    while ($ligne2 = $requete2 -> fetch())
                    {?>
                        <tr>
                            <form method="POST" action="Liste_Famille.php">
                                <td><input type="text" name="login" id="login" readonly="readonly" class="input" value="<?= $ligne2['compte_login'] ?>"/></td>
                                <td><?= $ligne2['compte_mail'] ?></td>
                                <td><input type="text" name="public" id="public" readonly="readonly" class="input" value="<?= $ligne2['compte_statu'] ?>"/></td>
                                <td><input type="submit" value="Changer le statut à 'secret'"/></td>
                            </form>
                        </tr>

                    <?php }
                    ?>
                </table>
                
            </section>
            
            
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>