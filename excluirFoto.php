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
    $id_anuncio = $a->excluirFoto($id);

    if (isset($id_anuncio)) {

        header('Location: editarAnuncio.php?id='.$id_anuncio);

        // print_r($id_anuncio);

    } else {

        header('Location: meusAnuncios.php?e=1');
    }


}
