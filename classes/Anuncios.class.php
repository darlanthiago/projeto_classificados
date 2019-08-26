<?php

class Anuncios
{

    public function getMeusAnuncios()
    {
        global $pdo;

        $array = array();

        $sql =
            "SELECT *, 
            (SELECT anuncio_imagem.url 
            FROM anuncio_imagem 
            WHERE anuncio_imagem.id_anuncio = anuncio.id LIMIT 1) as url 
            FROM anuncio 
            WHERE id_usuario = :id_usuario";

        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id_usuario', $_SESSION['login']);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function addAnuncio($categoria, $titulo, $valor, $descricao, $estado)
    {

        global $pdo;

        $sql = "INSERT INTO anuncio(id_usuario, id_categoria, titulo, descricao, preco, estado) 
                VALUES(:id_usuario, :id_categoria, :titulo, :descricao, :preco, :estado)";

        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id_usuario', $_SESSION['login']);
        $sql->bindValue(':id_categoria', $categoria);
        $sql->bindValue(':titulo', $titulo);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':preco', $valor);
        $sql->bindValue(':estado', $estado);

        $sql->execute();

        return true;
    }

    public function deletarAnuncio($id)
    {

        global $pdo;

        $id_anuncio = null;

        $sql = "SELECT * FROM anuncio_imagem WHERE id_anuncio = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $url_anuncio = $sql->fetchAll(PDO::FETCH_ASSOC);

            // print_r($url_anuncio);

            foreach ($url_anuncio as $img_anuncio) {

                // print_r($img_anuncio);

                $filename = $img_anuncio['url'];

                unlink('./assets/img/anuncios/' . $filename);
            }
        }

        $sql = "DELETE FROM anuncio_imagem WHERE id_anuncio = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        $sql = "DELETE FROM anuncio WHERE id = $id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();


        return true;
    }

    public function getAnuncio($id)
    {
        global $pdo;

        $array = array();
        $array['fotos'] = array();

        $sql = "SELECT *, (SELECT nome FROM categoria WHERE anuncio.id_categoria = categoria.id) as cat FROM anuncio WHERE id = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $array = $sql->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT id, url FROM anuncio_imagem WHERE id_anuncio = :id_anuncio";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id_anuncio', $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {

                $array['fotos'] = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

            return $array;
        } else {

            return false;
        }
    }


    public function editAnuncio($categoria, $titulo, $valor, $descricao, $estado, $fotos, $id)
    {

        global $pdo;

        $sql = "UPDATE anuncio SET  id_categoria = :id_categoria, titulo = :titulo, 
                                    descricao = :descricao, preco = :preco, estado = :estado
                WHERE id = $id";

        $valor = floatval(str_replace(",", "", $valor));

        $sql = $pdo->prepare($sql);

        $sql->bindValue(':id_categoria', $categoria);
        $sql->bindValue(':titulo', $titulo);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':preco', $valor);
        $sql->bindValue(':estado', $estado);
        $sql->execute();

        if (count($fotos) > 0) {

            for ($q = 0; $q < count($fotos['tmp_name']); $q++) {

                $tipo = $fotos['type'][$q];

                if (in_array($tipo, array('image/jpeg', 'image/png'))) {

                    $filename = md5(time() . rand(0, 99999)) . '.jpg';
                    move_uploaded_file($fotos['tmp_name'][$q], 'assets/img/anuncios/' . $filename);

                    list($width_orig, $heigth_orig) = getimagesize('assets/img/anuncios/' . $filename);

                    $ratio = $width_orig / $heigth_orig;

                    $width = 500;
                    $heigth = 500;

                    if ($width / $heigth > $ratio) {

                        $width = $heigth * $ratio;
                    } else {
                        $heigth = $width / $ratio;
                    }

                    $img = imagecreatetruecolor($width, $heigth);

                    if ($tipo == 'image/jpeg') {

                        $orginal_image = imagecreatefromjpeg('assets/img/anuncios/' . $filename);
                    } else if ($tipo == 'image/png') {

                        $orginal_image = imagecreatefrompng('assets/img/anuncios/' . $filename);
                    }


                    imagecopyresampled($img, $orginal_image, 0, 0, 0, 0, $width, $heigth, $width_orig, $heigth_orig);

                    imagejpeg($img, 'assets/img/anuncios/' . $filename, 80);


                    $sql = "INSERT INTO anuncio_imagem(id_anuncio, url) VALUES(:id_anuncio, :url)";
                    $sql = $pdo->prepare($sql);
                    $sql->bindValue(':id_anuncio', $id);
                    $sql->bindValue(':url', $filename);
                    $sql->execute();
                }
            }
        }

        return true;
    }

    public function excluirFoto($id)
    {


        global $pdo;

        $id_anuncio = null;

        $sql = "SELECT * FROM anuncio_imagem WHERE id = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $url_anuncio = $sql->fetch(PDO::FETCH_ASSOC);
            $id_anuncio = $url_anuncio['id_anuncio'];
            $filename = $url_anuncio['url'];
        }

        //Excluir do banco de dados


        $sql = "DELETE FROM anuncio_imagem WHERE id = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        //Excluir da pasta


        unlink('./assets/img/anuncios/' . $filename);


        return $id_anuncio;
    }

    public function getTotalAnuncios()
    {

        global $pdo;

        $sql = "SELECT count(id) as total FROM anuncio";

        $sql = $pdo->prepare($sql);

        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        $resultado = $resultado['total'];

        return $resultado;
    }


    public function getUltimosAnuncios($page, $perPage)
    {

        global $pdo;

        $offset = ($page - 1) * $perPage;

        $array = array();

        // $params = array();

        if (isset($params) && !empty($params)) {
            $sql =
                "SELECT *, 
                (SELECT anuncio_imagem.url 
                FROM anuncio_imagem 
                WHERE anuncio_imagem.id_anuncio = anuncio.id LIMIT 1) as url,
                (SELECT categoria.nome
                FROM categoria 
                WHERE categoria.id = anuncio.id_categoria) as categoria
            FROM anuncio ORDER BY id DESC LIMIT $offset, $perPage WHERE id_categoria = :categoria";
            
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':categoria');


        } else {

            $sql =
                "SELECT *, 
                (SELECT anuncio_imagem.url 
                FROM anuncio_imagem 
                WHERE anuncio_imagem.id_anuncio = anuncio.id LIMIT 1) as url,
                (SELECT categoria.nome
                FROM categoria 
                WHERE categoria.id = anuncio.id_categoria) as categoria
            FROM anuncio ORDER BY id DESC LIMIT $offset, $perPage";
        }

        $sql = $pdo->prepare($sql);
        
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;

    // print_r($params);
    }
}
