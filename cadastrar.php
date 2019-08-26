<?php

include_once "inc/header.php";

?>


<div class="container mt-3">

    <div class="display-4 mb-4">Cadastre-se</div>
    <?php

    require_once "classes/Usuarios.class.php";
    $u = new Usuario();

    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
        $telefone = addslashes($_POST['telefone']);

        if (!empty($nome) && !empty($email) && !empty($senha)) {

            if ($u->cadastrar($nome, $email, $senha, $telefone)) { ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Usuário cadastrado com sucesso! </strong><a href="login.php" class="alert-link">Clique aqui para fazer o login!</a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            <?php
            } else { ?>

                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Usuário já existe </strong><a href="login.php" class="alert-link">Clique aqui para fazer o login!</a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            <?php }
        } else { ?>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Opa! </strong>Preencha todos os campos!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php

        }
    }
    ?>

    <form method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nome" placeholder="Digite seu nome">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
        </div>
        <div class="form-group">
            <label for="telefone">Celular</label>
            <input type="tel" class="form-control" name="telefone" id="telefone" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" placeholder="Digite seu celular">
        </div>


        <button type="submit" class="btn btn-dark">Cadastrar</button>
    </form>


</div>




<?php

include_once "inc/footer.php";

?>