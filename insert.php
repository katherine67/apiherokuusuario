<?php 

    header  ("Access-Control-Allow-Origin: *");
    header  ("Access-Control-Allow-Headers: access");
    header  ("Access-Control-Allow-Methods: POST");
    header  ("Content-Type: application/json; Charset=UFT-8");
    header  ("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    require 'config.php';
    $db_connection = new database();
    $conn = $db_connection->dbconnection();

    $data = json_decode(file_get_contents("php://input"));

    $msg['message'] = '';

    if(isset($data->nombres) && isset($data->correo) && isset($data->contraseña)){
        if(!empty($data->nombres) && !empty($data->correo) && !empty($data->contraseña)){
            $insert_query = "INSERT INTO `usuarios` (nombres,correo,contraseña) VALUES (:nombres,:correo,:contraseña)";
            
            $insert_stmt = $conn->prepare($insert_query);

            $insert_stmt -> bindValue('nombres', htmlspecialchars(strip_tags($data->nombre)),PDO::PARAM_STR);
            $insert_stmt -> bindValue('correo', htmlspecialchars(strip_tags($data->curso)),PDO::PARAM_STR);
            $insert_stmt -> bindValue('contraseña', htmlspecialchars(strip_tags($data->nota1)),PDO::PARAM_STR);
            

            if($insert_stmt->execute()){
                $msg['message'] = 'datos insertados correctamente';
            }else{
                $msg['message'] = 'datos no insertados';
            }
        }else{
            $msg['message'] = 'OOOOPS! hay un campo desocupado, por favor diligenciar todos los espacios.';
        }
    }else{
        $msg['message'] = 'Por favor diligenciar todos los campos.';
    }
    echo json_encode($msg);
?>