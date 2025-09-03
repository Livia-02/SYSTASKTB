<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir a conexão com o banco de dados
include_once '../../connection/con.php';

// Se for requisição PUT (ou POST, dependendo da configuração)
if ($_SERVER["REQUEST_METHOD"] === "PUT") {

    // Lê os dados recebidos via PUT
    $data = json_decode(file_get_contents("php://input"));

    // Valida se os campos não estão vazios
    if (
        !empty($data->id) &&
        !empty($data->name) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->level)
    ) {
        $id = $data->id;
        $name = $data->name;
        $email = $data->email;
        $password = $data->password;
        $level = $data->level;

        try {
            // Instrução SQL para atualizar dados
            $sql = "UPDATE user SET name = ?, email = ?, password = ?, level = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $email, $password, $level, $id]);

            // Resposta de sucesso em JSON
            http_response_code(200);
            echo json_encode(array("message" => "Registro atualizado com sucesso!"));
        } catch (PDOException $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Erro ao atualizar o registro."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Existem campo(s) obrigatório(s) não preenchido(s)."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido."));
}

?>
