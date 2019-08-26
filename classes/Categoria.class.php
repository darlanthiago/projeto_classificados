<?php

class Categoria{



    public function getCategorias(){
        global $pdo;
        $array = array();

        $sql = "SELECT * FROM categoria";
        $sql = $pdo->prepare($sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            
        }

        return $array;
    }
}