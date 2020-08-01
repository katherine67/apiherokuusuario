<?php 

    header  ("Access-Control-Allow-Origin: *");
    header  ("Access-Control-Allow-Headers: access");
    header  ("Access-Control-Allow-Methods: GET");
    header  ("Access-Control-Allow-Credentials: true");
    header  ("Content-Type: application/json; charset=UFT-8");

    require 'config.php';
    $db_connection = new Database();
    $conn = $db_connection->dbConnection();

    if(isset($_GET['id'])){
        $post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
            'options' => [
                'default' => 'all_post',
                'min_range' => 1
            ]
        ]);
    }
    else {
        $post_id = 'all_post';
    }

    $sql = is_numeric($post_id) ? "SELECT * FROM `usuarios` WHERE id='$post_id'" : "SELECT * FROM `usuarios`";
    $stmt = $conn->prepare($sql);
    $stmt -> execute();

    if($stmt->  rowCount() > 0){
        $usuarios_array = [];
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
            $post_data = [
                'id'=>  $row['id'],
                'Nombres' =>  $row['Nombres'],
                'Correo'=>  $row['Correo'],
                'Contraseña'=>  $row['Contraseña']   
            ];
            array_push($usuarios_array, $post_data);
        }
        echo json_encode($usuarios_array);
    }
    else{
        echo json_encode(['message' => 'usuario No Encontrado']);
    }
?>