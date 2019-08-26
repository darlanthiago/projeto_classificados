<?php

require_once "inc/header.php";

if (empty($_SESSION['login'])) {

    ?>


<script>
    window.location.href = "login.php";
</script>


<?php


    exit;
}
require_once "./classes/Anuncios.class.php";
$a = new Anuncios();

if (isset($_POST['titulo']) && !empty('titulo')) {

    $categoria = addslashes($_POST['categoria']);
    $titulo = addslashes($_POST['titulo']);
    $valor = addslashes($_POST['valor']);
    $descricao = addslashes($_POST['descricao']);
    $estado = addslashes($_POST['estado']);


    if ($a->addAnuncio($categoria, $titulo, $valor, $descricao, $estado)) { ?>

        <div class="container mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Anúncio cadastrado com sucesso! </strong><a href="meusAnuncios.php" class="alert-link">Clique aqui para fazer o ver seus Anúncios!</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

<?php }
}


?>


<div class="container mt-4">
    <h1>Meu Anúncios - Adicionar Anúncio</h1>

    <form method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option value="">--Selecione uma categoria--</option>
                <?php
                require_once "./classes/Categoria.class.php";
                $categoria = new Categoria();
                $cats = $categoria->getCategorias();
                // print_r($cats);

                foreach ($cats as $cat) { ?>

                <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>

                <?php }


                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="categoria">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text" name="valor" id="valor" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="categoria">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" style="height: 200px;" required></textarea>
        </div>

        <div class="form-group">
            <label for="estado">Estado de Conservação</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="">--Selecione um estado de conservação--</option>
                <option value="0">Ruim</option>
                <option value="1">Bom</option>
                <option value="2">Ótimo</option>
                <option value="3">Novo</option>
            </select>
        </div>
        <!-- 
        <div class="form-group">
            <label for="fotos">Fotos do Anúncio</label>
            <input type="file" class="form-control-file" id="fotos">
        </div> -->

        <input type="submit" class="btn btn-dark form-submit" value="Adicionar Anúncio">

    </form>
</div>

<?

require_once "inc/footer.php";

?>