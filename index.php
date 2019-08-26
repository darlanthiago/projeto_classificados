<?php

require_once "inc/header.php";
require_once "./classes/Anuncios.class.php";
require_once "./classes/Usuarios.class.php";
require_once "./classes/Categoria.class.php";
// require_once "./classes/Search.class.php";

$a = new Anuncios();
$u = new Usuario();
$c = new Categoria();
// $s = new Search();

$total_anuncios = $a->getTotalAnuncios();
$total_usuarios = $u->getTotalUsuarios();
$categorias = $c->getCategorias();

$p = 1;

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $p = addslashes($_GET['p']);
}

$porPagina = 4;

$total_paginas = ceil($total_anuncios / $porPagina);

$anuncios = $a->getUltimosAnuncios($p, $porPagina);

// print_r($_GET);

?>

<div class="container-fluid mt-3">
    <?php if (!isset($_SESSION['login'])) : ?>
    <div class="jumbotron">
        <h2 class="display-3">Nós temos hoje <?= $total_anuncios ?> anúncios</h2>
        <p class="lead">E mais de <?= $total_usuarios ?> usuários cadastrados.</p>
    </div>
    <?php endif; ?>

    <div class="row">

        <div class="col-sm-3">
            <h4>Pesquisa Avançada</h4>
            <form method="get">

                <div class="form-group">
                    <label for="categoria">Categoria</label>

                    <select name="search[categoria]" class="form-control" id="categoria">

                        <option></option>

                        <?php foreach ($categorias as $categoria) : ?>

                        <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <button type="submit" class="btn btn-dark"><i class="fas fa-search pr-2"></i>Buscar</button>

            </form>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-9">
                    <h4>Últimos Anúncios</h4>
                </div>
                <div class="col-sm-3 float-right">
                    <nav aria-label="...">
                        <ul class="pagination">

                            <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>

                            <li class="page-item <?= ($i == $p) ? 'active' : '' ?> text-dark"><a class="page-link bg-dark text-light border border-secondary" href="index.php?p=<?= $i ?>"><?= $i ?></a></li>

                            <?php endfor; ?>

                        </ul>
                    </nav>
                </div>

            </div>
            <table class="table border table-striped">

                <tbody>

                    <?php foreach ($anuncios as $anuncio) : ?>

                    <tr>
                        <td>

                            <?php if (!empty($anuncio['url'])) { ?>

                            <a href="assets/img/anuncios/<?= $anuncio['url'] ?>" data-fancybox="gallery">
                                <img src="assets/img/anuncios/<?= $anuncio['url'] ?>" class="rounded border shadow-sm" alt="Imagem" width="150" style="max-height: 110px">
                            </a>

                            <?php } else { ?>

                            <img src="assets/img/default.png" alt="Imagem" width="150" class="rounded border" style="max-height: 110px">

                            <?php } ?>
                        </td>

                        <td>
                            <a href="produto.php?id=<?= $anuncio['id'] ?>" id="link-index"><?= $anuncio['titulo'] ?></a>
                        </td>

                        <td><?= $anuncio['categoria'] ?></td>

                        <td>R$ <?= number_format($anuncio['preco'], 2) ?></td>
                    </tr>


                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>

    </div>

</div>

<?php

include_once "inc/footer.php";

?>