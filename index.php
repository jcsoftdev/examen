<?php include('./bd.php') ?>
<?php include('./includes/header.php') ?>

<h1 class="text-success text-center p-4"> Desarrollo del aplicativo </h1>
<div class="container-fluid p-4">

    <div class="row">
        <div class="col-12 col-md-4">
            <!-- MESSAGES -->

            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php session_unset();
            } ?>

            <div class="card car-body p-3 m-2">
                <h2 class="text-primary text-center p-2">Módulo de Administración</h2>
                <form action="./database/insertar.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group ">

                        <input class="form-control mb-3" type="text" name="nickname" placeholder="nickname" required>
                        <input class="form-control mb-3" type="text" name="nombreApellido" placeholder="nombreApellido" required>
                        <input class="form-control mb-3" type="email" name="email" placeholder="email" required>
                        <input class="form-control mb-3" type="password" name="password" placeholder="password" required>
                        <input class="form-control mb-3" type="date" name="fechanacimiento" placeholder="f_nac" required>


                        <input class="btn btn-success" name="insertar" type="submit" value="Insertar">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card m-2">
                <div class="table-responsive">
                    <h2 class="text-center text-info">Lista de Usuarios</h2>
                    <table class="table table-hover table-info">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">email</th>
                                <th scope="col">fecha nacimiento</th>
                                <th scope="col">fecha creacion</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $query = "SELECT * FROM usuario";
                            $result_tasks = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id']; ?></th>
                                    <td><?php echo $row['nickName']; ?></td>
                                    <td><?php echo $row['nombreApellido']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['fechanacimiento']; ?></td>
                                    <td><?php echo $row['fechaCreacion']; ?></td>
                                    <td class="">
                                        <a href="./database/actualizar.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                                            <i class="fas fa-marker"></i>
                                        </a>
                                        <a href="./database/eliminar.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">
                                            <i class="far fa-trash-alt"></i>
                                        </a>

                                        
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>