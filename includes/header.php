<?php
require_once "includes/functions.php";
$url = $_SERVER['REQUEST_URI'];
$url = str_replace("/projetweb-docteur-perie/", "", $url);
?>

<h2 class="titre">LA BOITE AUX PAPILLONS</h2>

<nav class="nav-fixed-top" role="navigation">
    <div class="container">
        <span class="col-lg-offset-3 col-lg-6">
        <ul class="nav navbar-nav">
            <li> <a href="Accueil.php" <?php if($url == "Accueil.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>>Accueil</a> </li>
            <li> <a href="A_Propos.php" <?php if($url == "A_Propos.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>>A propos</a> </li>
            <li> <a href="Galeries.php" <?php if($url == "Galeries.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>>Galeries</a> </li>
            <li> <a href="Liens.php" <?php if($url == "Liens.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>>Liens</a> </li>
            <li> <a href="Contact.php" <?php if($url == "Contact.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>>Contact</a> </li>

            <?php if (isAdminConnected()) { ?>
            <li class="dropdown">
                <a href="#" <?php if($url == "login.php"){echo 'class="dropdown-toggle active"';} else{echo 'class="dropdown-toggle mot"';} ?> data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user"></span> Administrateur<b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="Accueil_Admin.php">Modifier Accueil</a></li>
                    <li><a href="A_propos_Admin.php">Modifier A propos</a></li>
                    <li><a href="Galerie_Admin.php">Modifier Galerie</a></li>
                    <li><a href="Liens_Admin.php">Modifier Liens</a></li>
                    <li><a href="Liste_famille.php">Liste famille</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="Compte.php">Mon Compte</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if (isFamillyConnected()) { ?>
            <li class="dropdown">
                <a href="#" <?php if($url == "login.php"){echo 'class="dropdown-toggle active"';} else{echo 'class="dropdown-toggle mot"';} ?> data-toggle="dropdown">
                    <span  class="mot"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['login'] ?> <b class="caret"></b></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="Compte.php">Mon Compte</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if (isUtilisateurConnected()) { ?>
            <li class="dropdown">
                <a href="#" <?php if($url == "login.php"){echo 'class="dropdown-toggle active"';} else{echo 'class="dropdown-toggle mot"';} ?> data-toggle="dropdown">
                    <span  class="mot"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['login'] ?> <b class="caret"></b></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="Compte.php">Mon Compte</a></li>
                    <li><a href="logout.php">Se déconnecter</a></li>
                </ul>
            </li>
            <?php } ?>

            <?php if (!isUtilisateurConnected() & !isFamillyConnected() & !isAdminConnected())  { ?>
            <li class="dropdown">
                <a href="login.php" <?php if($url == "login.php"){echo 'class="active"';} else{echo 'class="mot"';} ?>> Connexion </a>
            </li>
            <?php } ?>
        </ul>
        </span>
        
    </div>
</nav>