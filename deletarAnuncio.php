<?php

require_once "./config.php";

if (empty($_SESSION['login'])) {

    header('Location: login.php');
    exit;
}


require_once "classes/Anuncios.class.php";
$a = new Anuncios();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = addslashes($_GET['id']);

    // echo $id;

    if ($a->deletarAnuncio($id)) {

        header('Location: meusAnuncios.php?s=deleteSucess');

    } else {

        header('Location: meusAnuncios.php?e=1');
    }


}
