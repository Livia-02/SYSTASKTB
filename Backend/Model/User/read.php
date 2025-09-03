<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir a conexão com o banco de dados
include_once '../../connection/con.php';

// Se for requisição GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    try {
        // Instrução SQL para ler dados
        $sql = "SELECT * FROM user";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Verifica se existem registros
        if ($stmt->rowCount() > 0) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($users);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Nenhum usuário encontrado."));
        }

    } catch (PDOException $e) {
        http_response_code(503);
        echo json_encode(array("message" => "Erro ao ler os registros."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido."));
}

?>
