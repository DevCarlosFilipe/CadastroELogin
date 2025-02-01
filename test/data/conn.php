<?php

// Variáveis de conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bd_teste";

try {
    $conn = new PDO ("mysql:host=$host;dbname=$dbname;", $user, $pass);
} catch (PDOException $err){
    echo "Erro ao conectar no banco de dados: " . $err->getMessage();
}