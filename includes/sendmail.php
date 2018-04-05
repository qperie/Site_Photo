<?php
    require_once "functions.php";
    
    $nom = $_POST['nom'];
    $mail = $_POST['mail'];
    $message = $_POST['mail'];
    $message = wordwrap($message, 70, "\r\n");
    $infosup = 'From: ' . $mail . "\r\n" . 'Reply-To: ' . $mail;
    
    echo($nom);

    mail('perieq@hotmail.fr','Contact du site photo', $message, $infosup);
?>

<script>alert("Merci pour votre message !");</script>
<?php redirect('../Contact.php'); ?>

