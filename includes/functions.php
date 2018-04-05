<?php

// Connect to the database. Returns a PDO object
function getDb()
{
    // Local deployment
    $server = "localhost";
    $username = "site_photo_user";
    $password = "secret";
    $db = "site_photo";

    // Deployment on Heroku with ClearDB for MySQL
    /*$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);*/

    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

// Check if a user is connected
function isUserConnected()
{
    return isset($_SESSION['login']);
}

//Check if admin is connected
function isAdminConnected()
{
    if (isset($_SESSION['login']))
    {
        if ($_SESSION['statu']=='admin')
        {
           return TRUE; 
        }
        return FALSE;
    }
    else
    {
        return FALSE;
    }
}

//chceck if a familly user is connected
function isFamillyConnected()
{
    if (isset($_SESSION['login']))
    {
        if($_SESSION['statu']=='secret')
        {
            return TRUE;
        }
        return FALSE;
    }
    return FALSE;
}


//check if someone is connected other than familly or admin
function isUtilisateurConnected()
{
    if(isset($_SESSION['login']))
    {
        if ($_SESSION['statu']=='public')
        {
            return TRUE;
        }
        return FALSE;
    }
    return FALSE;
}

// Redirect to a URL
function redirect($url)
{
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

