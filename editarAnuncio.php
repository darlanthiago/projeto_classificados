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

    if (isset($_FILES['fotos'])) {
        $fotos = $_FILES['fotos'];
    } else {
        $fotos = array();
    }

    $id = $_GET['id'];

    if ($a->editAnuncio($categoria, $titulo, $valor, $descricao, $estado, $fotos, $id)) { ?>

<div class="container mt-2">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Anúncio salvo com sucesso! </strong><a href="meusAnuncios.php" class="alert-link">Clique aqui para fazer o ver todos seus Anúncios!</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<?php }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $info = $a->getAnuncio($_GET['id']);

    // print_r($info);

} else { ?>

<script>
    window.location.href = "meusAnuncios.php";
</script>

<?php }


?>


<div class="container mt-4">
    <h1>Meu Anúncios - Editar Anúncio</h1>

    <form method="post" enctype="multipart/form-data">

        <div class="form-row">
            <div class="col-sm">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    <?php
                    require_once "./classes/Categoria.class.php";
                    $categoria = new Categoria();
                    $cats = $categoria->getCategorias();
                    // print_r($cats);

                    foreach ($cats as $cat) { ?>

                    <option value="<?= $cat['id'] ?>" <?= ($info['id_categoria'] == $cat['id']) ? "selected='selected'" : '' ?>><?= $cat['nome'] ?></option>

                    <?php }


                    ?>
                </select>
            </div>

            <div class="col-sm">
                <label for="categoria">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required value="<?= $info['titulo'] ?>">
            </div>

        </div>

        <div class="form-row mt-3">
            <div class="col-sm">
                <label for="valor">Valor</label>
                <input type="text" name="valor" id="valor" class="form-control" required value="<?= number_format($info['preco'], 2) ?>">
            </div>

            <div class="col-sm">
                <label for="estado">Estado de Conservação</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="0" <?= ($info['estado'] == 0) ? "selected='selected'" : '' ?>>Ruim</option>
                    <option value="1" <?= ($info['estado'] == 1) ? "selected='selected'" : '' ?>>Bom</option>
                    <option value="2" <?= ($info['estado'] == 2) ? "selected='selected'" : '' ?>>Ótimo</option>
                    <option value="3" <?= ($info['estado'] == 3) ? "selected='selected'" : '' ?>>Novo</option>
                </select>
            </div>

        </div>

        <div class="form-group mt-3">
            <label for="categoria">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" style="height: 200px;" required><?= $info['descricao'] ?></textarea>
        </div>

        <div class="form-group pb-2">
            <label for="fotos">Fotos do Anúncio</label>
            <input type="file" class="form-control-file mb-3" name="fotos[]" accept="image/*" multiple>
        <div class="card-deck border m-0 pb-5 pt-2">

                <?php

                if (isset($info['fotos']) && !empty($info['fotos'])) {
                    foreach ($info['fotos'] as $foto) { ?>

                <div class="card" style="max-width: 300px">
                    <img src="./assets/img/anuncios/<?= $foto['url'] ?>" alt="Foto" class="card-img-top" height='200px'>
                    <div class="card-body">
                        <a href="excluirFoto.php?id=<?= $foto['id'] ?>" class="btn btn-danger w-100 card-link mt-2">Remover</a>
                    </div>
                </div>

                <?php }
                } else { ?>

                <div class="card mt-3">
                    <div class="card-body">

                        <div class="text-center text-dark">Não há fotos nesse Anúncio</div>

                    </div>
                </div>


                <?php } ?>

            </div>
            </div>

            
            
            <button type="submit" class="btn btn-dark form-submit mb-4 w-50">Salvar</button>



    </form>
</div>

<?

require_once "inc/footer.php";

?>