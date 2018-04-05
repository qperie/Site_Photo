<?php
require_once "includes/functions.php";
session_start();
?>

<!doctype html>
<html>

    <?php require_once "includes/head.php"; ?>

    <body>
        <div class="container">
            <?php require_once "includes/header.php"; ?> <br/>
            
            <div class="row">
                <section class="col-xs-12 col-md-5"><img src="images/contact.jpg" alt="Photo" class="img-responsive image"/></section>
                <section class="col-xs-12 col-md-7">
                  <form method="POST" action="includes/sendmail.php">
                    <div>Une question, une suggestion, un commentaire ...</div>
                    <div>N'hésitez pas, cette page est pour vous.</div>
                    
                    <h3><strong>Eric PÉRIÉ</strong></h3>
                    <h4>perie.eric@neuf.fr</h4><br/>
                    
                    <fieldset>
                      <h4><u>Formulaire de contact</u></h4>
                      <div>
                        <label for='nom'>Votre nom :</label><br/>
                        <input type='text' name='nom' size ='100%' required/>
                        </div><br/>
                      <div>
                        <label for='mail'>Votre adresse e-mail (pour vous répondre) :</label><br/>
                        <input type='email' name='mail' size ='100%' required/>
                      </div><br/>
                      <div>
                        <label for="textarea">Votre message :</label><br/>
                        <textarea id="textarea" class="form-control" rows="4" name="message"></textarea><br/>
                        <button class="btn btn-primary pull-right" type="submit">Envoyer</button>
                      </div><br/>
                    </fieldset>

                  </form>
                </section>
            </div><br/>
            
            <h4 class="photographe">
                <a href="mailto:perieq@hotmail.fr" class="mot"><u>Contact par mail direct</u></a>
            </h4><br/>
        
            <?php require_once "includes/footer.php"; ?>
        </div>

        <?php require_once "includes/scripts.php"; ?>
    </body>

</html>