<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../connection/con.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $data = json_decode(file_get_contents("php://input"));


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

            $sql = "INSERT INTO user(name, email, password, level) VALUES(?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $email, $password, $level]);


            http_response_code(201);
            echo json_encode(array("message" => "Registro salvo com sucesso!"));
        } catch (PDOException $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Erro ao salvar o registro."));
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
