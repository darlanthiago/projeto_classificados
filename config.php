<?php

session_start();

global $pdo;

try {
    
    $pdo = new PDO('mysql:dbname=projeto_classificados;host=localhost;charset=UTF8', 'root', '');

    return $pdo;
    
} catch (PDOException $e) {
    
    echo "Erro na conexão. Erro: ". $e->getMessage();
}