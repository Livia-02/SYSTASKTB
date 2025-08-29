<?php

$hostname = "localhost";
$dbname = "SysTask";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão com o banco de dados realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro: Conexão com o banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
}

?>