<!-- incluyendo la conexion a la base de datos -->
<?php include('../bd.php') ?>

<?php
function mysql_fetch_all($res)
{
    while ($row = mysqli_fetch_array($res)) {
        $return[] = $row;
    }
    return $return;
}

if (isset($_POST['insertar'])) {

    $nickName = $_POST['nickname'];
    $nombreApellido = $_POST['nombreApellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fechanacimiento = $_POST['fechanacimiento'];

    $query = "SELECT nickName FROM usuario";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "No se pudo obtener Datos";
    } else {
        $row2 = mysql_fetch_all($result);
    }
    $cont = 0;
    foreach ($row2 as $key => $value) {
        if ($value[0] == $nickName) {
            $cont++;
        }
    }
    if ($cont > 0) {
        $_SESSION['message'] = 'El usuario ya existe';
        $_SESSION['message_type'] = 'danger';

        header('Location: ../index.php');
    } else {
        $uno = 1;

        try {
            $stmt = $conn->prepare('INSERT INTO usuario(nickName,nombreApellido,Email,password,fechanacimiento,usuario_rol_id, usuario_estado_id) VALUES (?,?,?,?,?,?,?)');
            $stmt->bind_param("sssssii", $nickName, $nombreApellido, $email, $password, $fechanacimiento, $uno, $uno);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;

            if ($stmt->affected_rows) {
                $res = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado
                );
            } else {
                $res = array('respuesta' => 'error');
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $res = array('respuesta' => $e->getMessage());
            echo $res;
        }
        $_SESSION['message'] = 'Articulo guardado correctamente';
        $_SESSION['message_type'] = 'success';
        header('Location: ../index.php');
    }
}
?>