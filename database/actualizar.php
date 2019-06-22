<!-- iExamen-->
<?php include('../bd.php') ?>
<?php include('../includes/header.php') ?>

<?php
function mysql_fetch_all($res)
{
    while ($row = mysqli_fetch_array($res)) {
        $return[] = $row;
    }
    return $return;
}
$codigo = '';
$nombre = '';
$stock = 0;
$descripcion = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare('SELECT * FROM usuario WHERE id=?');
    if ($stmt === false) {
        /* Puedes hacer un return con ok a false o lanzar una excepción */
        /*throw new Exception('Error en prepare: ' . $stmt->error);*/
        return ['ok' => 'false'];
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    // obteniendo los datos
    $nickName = $row['nickName'];
    $nombreA = $row['nombreApellido'];
    $email = $row['Email'];
    $password = $row['password'];
    $fechanacimiento = $row['fechanacimiento'];
}
if (isset($_POST['actualizar'])) {
    // $respuesta = array('post' => $_POST, 'file' => $_FILES);
    // print_r(json_encode($respuesta));


    $query = "SELECT * FROM usuario WHERE id<>'$id'";
    $result = mysqli_query($conn, $query);
    // $row2 = mysqli_fetch_assoc($result);
    if (!$result) {
        echo "No se pudo obtener Datos";
    } else {
        $row2 = mysql_fetch_all($result);
    }
    $cont = 0;
    foreach ($row2 as $key => $value) {
        print_r($value[2]);
        if ($value[2] == $_POST['nickName']) {
            $cont++;
        }
    }
    if ($cont > 0) {
        // print_r($row2);

        ?>
        <div class="container p-4">
            <!-- MESSAGES -->


            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                EL usuario seleccionado ya existe
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php

} else {

    $nickName = $_POST['nickName'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fechanacimiento = $_POST['fechanacimiento'];
    try {
        $stmt = $conn->prepare('UPDATE usuario set nickName = ? ,nombreApellido = ?,Email = ?,password = ?,fechanacimiento = ? WHERE id=?');
        $stmt->bind_param("sssssi", $nickName, $nombre, $email, $password, $fechanacimiento, $id);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if ($stmt->affected_rows) {
            $res = array(
                'respuesta' => 'exito',
                'id_insertado' => $id_insertado,
            );
        } else {
            $res = array('respuesta' => 'error');
        }
        $stmt->close();
        $conn->close();
        $_SESSION['message'] = 'Se actualizo correctamente';
        $_SESSION['message_type'] = 'warning';

        header('Location: ../index.php');
    } catch (Exception $e) {
        $res = array('respuesta' => $e->getMessage());
        echo $res;
    }
}
}
?>




<div class="row bg-gradient-primary">
    <div class=" col-md-4 mx-auto my-auto">
        <div class="card card-body bg-info">
            <form action="actualizar.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group ">

                    <div class="form-group">
                        <input class="form-control mb-3" type="text" name="nickName" placeholder="nickName" value="<?php echo $nickName; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-3" type="text" name="nombre" placeholder="nombre" value="<?php echo $nombreA; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-3" type="email" name="email" placeholder="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-3" type="text" name="password" placeholder="password" value="<?php echo $password; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-3" type="date" name="fechanacimiento" placeholder="fechanacimiento" value="<?php echo date('Y-m-d', strtotime($fechanacimiento)); ?>">
                    </div>

                </div>
                <button class="btn btn-success" name="actualizar">
                    Update
                </button>
                <a class="btn btn-warning" href="../index.php">Volver</a>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php') ?>