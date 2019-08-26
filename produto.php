<?php

require_once "inc/header.php";
require_once "./classes/Anuncios.class.php";
require_once "./classes/Usuarios.class.php";

$a = new Anuncios();
$u = new Usuario();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = addslashes($_GET['id']);
} else {
    header('Location: index.php');
    exit;
}

$info = $a->getAnuncio($id);

$url = $info['fotos'];

// print_r($url);
// print_r($info);


?>


<div class="container mt-3">

    <h3>Área dos Produtos</h3>

    <div class="row mt-5">
        <div class="col-sm-6">

            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner shadow-sm">

                    <?php foreach ($url as $indice => $foto) : ?>

                    <div class="carousel-item <?= ($indice == 0) ? 'active' : '' ?>">
                        <img src="./assets/img/anuncios/<?= $foto['url'] ?>" class="d-block w-100 border rounded shadow-sm" style="height: 380px;" alt="foto">
                    </div>
                    <?php endforeach; ?>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon text-dark" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>


        </div>

        <div class="col-sm-6 pr-2 pl-3 shadow-sm border rounded bg-light">

            <div class="container mt-2">

                <div class="row">
                    <div class="col-sm-9 pl-0">
                        <h2><strong><?= $info['titulo'] ?></strong></h2>
                    </div>
                    <div class="col-sm-3">
                        <i class="far heart fa-heart text-danger float-right" onclick="desejos(this);" ></i>
                    </div>
                </div>

                <div class="row mt-1">
                    <div>
                        <h5><?= $info['descricao'] ?></h5>
                        <div>
                            <small class="m-0">Departamento: <?=$info['cat']?></small>
                        </div>
                        <div>
                            <small class="m-0">Codigo: <?= $info['id'] ?></small>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <h4>Preço: R$ <?= number_format($info['preco'], 2) ?></h4>
                </div>

                <form action="">

                <div class="row mt-4 pb-3">
                    <label for="qtde" class="pt-2 pb-2">Quantidade: </label>
                    <div class="col-sm-9">
                        <input type="number" id="qtde" class="form-control w-50" value="1">
                    </div>

                </div>

                <div class="row text-center mt-2 mb-1">
                    <button type="submit" class="btn btn-comprar btn-primary btn-lg btn-block">Comprar</button>
                </div>

                

                </form>




            </div>

        </div>
    </div>

</div>


<?php

include_once "inc/footer.php";

?>