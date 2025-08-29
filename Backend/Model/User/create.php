<?php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir a conexão com o banco de dados
include_once '../../connection/con.php';

// Se for requisição POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Lê os dados recebidos via POST
    $data = json_decode(file_get_contents("php://input"));

    // Valida se os campos não estão vazios
    if (
        !empty($data->name) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->level)
    ) {
        $name = $data->name;
        $email = $data->email;
        $password = $data->password;
        $level = $data->level;

        try {
            // Instrução SQL para inserir dados
            $sql = "INSERT INTO user(name, email, password, level) VALUES(?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $email, $password, $level]);

            // Resposta de sucesso em JSON
            http_response_code(201); // 201 Created
            echo json_encode(array("message" => "Registro salvo com sucesso!"));
        } catch (PDOException $e) {
            http_response_code(503); // 503 Service Unavailable
            echo json_encode(array("message" => "Erro ao salvar o registro."));
        }
    } else {
        http_response_code(400); // 400 Bad Request
        echo json_encode(array("message" => "Existem campo(s) obrigatório(s) não preenchido(s)."));
    }
} else {
    http_response_code(405); // 405 Method Not Allowed
    echo json_encode(array("message" => "Método não permitido."));
}

?>
