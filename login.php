<?php

include_once "inc/header.php";

?>


<div class="container mt-3">

    <div class="display-4 mb-4">Login</div>
    <?php

    require_once "classes/Usuarios.class.php";
    $u = new Usuario();

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if ($u->validaLogin($email, $senha)) { ?>

            <script>
                window.location.href = "./";
            </script>

            <?php

            exit;
        } else { ?>


            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Usuário e/ou Senha incorretos!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


        <?php }
    } ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
        </div>
        <button type="submit" class="btn btn-dark">Entrar</button>
    </form>


</div>




<?php

include_once "inc/footer.php";

?>