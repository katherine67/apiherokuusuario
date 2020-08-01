<?php 

    header  ("Access-Control-Allow-Origin: *");
    header  ("Access-Control-Allow-Headers: access");
    header  ("Access-Control-Allow-Methods: PUT");
    header  ("Content-Type: application/json; Charset=UFT-8");
    header  ("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");

    require 'config.php';
    $db_connection = new database();
    $conn = $db_connection->dbconnection();

    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id)){
        $msg['message'] = '';
        $post_id = $data->id;

        $get_post = "SELECT * FROM `usuarios` WHERE id=:post_id";
        $get_stmt = $conn->prepare($get_post);
        $get_stmt->bindValue(':post_id',$post_id,PDO::PARAM_INT);
        $get_stmt->execute();

        if($get_stmt->rowCount() > 0){
            $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
            $post_Nombres = isset($data->Nombres) ? $data->Nombres : $row['Nombres'];
            $post_Correo = isset($data->Correo) ? $data->Correo : $row['Correo'];
            $post_Contraseña = isset($data->Contraseña) ? $data->Contraseña : $row['Contraseña'];
            
            $update_query = "UPDATE `usuarios` SET Nombres=:Nombres, Correo=:Correo, Contraseña=:Contraseña, WHERE id=:id";

            $update_stmt = $conn->prepare($update_query);

            $update_stmt->bindValue(':Nombres', htmlspecialchars(strip_tags($post_Nombres)), PDO::PARAM_STR);
            $update_stmt->bindValue(':Correo', htmlspecialchars(strip_tags($post_Correo)), PDO::PARAM_STR);
            $update_stmt->bindValue(':Contraseña', htmlspecialchars(strip_tags($post_Contraseña)), PDO::PARAM_STR);
           $update_stmt->bindValue(':id',$post_id, PDO::PARAM_INT);

            if($update_stmt->execute()){
                $msg['message'] = 'Datos actualizados correctamente';
            }else{
                $msg['message'] = 'Datos no encontrados';
            }
        }else{
            $msg['message'] = 'ID invalido';
        }
        echo json_encode($msg);
    }

?>