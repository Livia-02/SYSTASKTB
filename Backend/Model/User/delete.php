<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir a conexão com o banco de dados
include_once '../../connection/con.php';

// Se for requisição DELETE (ou POST, dependendo da configuração)
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {

    // Lê os dados recebidos via DELETE
    $data = json_decode(file_get_contents("php://input"));

    // Valida se o ID não está vazio
    if (!empty($data->id)) {
        $id = $data->id;

        try {
            // Instrução SQL para deletar dados
            $sql = "DELETE FROM user WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);

            // Resposta de sucesso em JSON
            http_response_code(200);
            echo json_encode(array("message" => "Registro excluído com sucesso!"));
        } catch (PDOException $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Erro ao excluir o registro."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "ID não fornecido."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido."));
}

?>
