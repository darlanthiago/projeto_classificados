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


if (isset($_GET['e']) && $_GET['e'] == '1') { ?>

<div class="container mt-3">

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Não foi possivel excluir o anúncio!</strong> Por favor, tente mais tarde.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

</div>



<?php } else if (isset($_GET['s']) && $_GET['s'] == 'deleteSucess') { ?>

<div class="container mt-3">

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Anúncio excluído com sucesso!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

</div>

<?php } ?>





<div class="container mt-4">
    <h1 class="pb-4">Meus Anúncios</h1>
    <a href="addAnuncio.php"><button class="btn btn-warning"><i class="fas fa-plus pr-2"></i>Adicionar Anúncio</button></a>
    <div class="table-responsive">
        <table class="table table-striped mt-4 border">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Título</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                require_once "./classes/Anuncios.class.php";
                $a = new Anuncios();
                $anuncios = $a->getMeusAnuncios();

                foreach ($anuncios as $anuncio) {
                    ?>

                <tr>
                    <td>
                        <?php if (!empty($anuncio['url'])) { ?>

                        <a href="assets/img/anuncios/<?= $anuncio['url'] ?>" data-fancybox="gallery">
                            <img src="assets/img/anuncios/<?= $anuncio['url'] ?>" class="rounded border"  alt="Imagem" width="150" style="max-height: 110px">
                        </a>


                        <?php } else { ?>

                        <img src="assets/img/default.png" alt="Imagem" class="rounded border" alt="Imagem" width="150" style="max-height: 110px">

                        <?php } ?>
                    </td>
                    <td><?= $anuncio['titulo'] ?></td>
                    <td>R$ <?= number_format($anuncio['preco'], 2) ?></td>
                    <td>
                        <a href="editarAnuncio.php?id=<?= $anuncio['id'] ?>" class="btn-acoes mr-2 p-1 text-warning" data-toggle="tooltip" data-placement="top" title="Editar Anúncio"><i class="fas fa-edit p-1"></i></a>
                        <a href="deletarAnuncio.php?id=<?= $anuncio['id'] ?>" class="btn-acoes p-1 text-danger" data-toggle="tooltip" data-placement="top" title="Deletar Anúncio"><i class="fas fa-trash p-1"></i></a>
                    </td>

                </tr>

                <?php
                }


                ?>
            </tbody>
        </table>
    </div>

</div>

<?

require_once "inc/footer.php";

?>