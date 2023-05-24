<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tabla con Bootstrap</title>

    <!-- Incluir archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>

    <script src="sweetalert2.all.js"></script>


</head>

<body style="background-color:#E3F3BF">
    <div class="container-fluid row">
        <!-- Agregar aquí el código PHP y HTML -->

        <?php

        require_once 'vendor/autoload.php'; // Incluye el archivo autoload.php de la biblioteca MongoDB

        $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
        $database = $mongoClient->selectDatabase('asignaturas');
        $collection = $database->selectCollection('materias');

        // Obtener los documentos existentes
        $documents = $collection->find([]);

        // Agregar un nuevo registro
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $id_estudiante = $_POST['id_estudiante'];

            $edad = $_POST['edad'];
            $email = $_POST['email'];

            $data = [
                'nombre' => $nombre,
                'id_estudiante' => $id_estudiante,

                'edad' => $edad,
                'email' => $email
            ];

            $result = $collection->insertOne($data);

            if ($result->getInsertedCount() > 0) {

                echo '<script>

                swal({
                        type:"success",
                          title: "¡CORRECTO!",
                          text: "El estudiante ha sido creado correctamente",
                          showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                      
                }).then(function(result){
 
                        if(result.value){   
                            window.location.href = "index.php";
                          } 
                });
          
 
            </script>';
            } else {
                echo "Error al insertar el registro.";
            }
        }
        ?>

        <form method="post" class="col-4" border-style: solid;>



            <div class="mb-3" border-style: solid;>
                <h3 style="text-align:center">REGISTRO ESTUDIANTE</h3>
                <div class="form-group">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="id_estudiante">ID Estudiante:</label>
                    <input type="number" name="id_estudiante" id="id_estudiante" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="edad">Edad:</label>
                    <input type="number" name="edad" id="edad" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Agregar Registro</button>
            <br><br><br>
        </form>

        <div class="col-8 p-4"> <!-- Tabla para visualizar los registros existentes -->
            <table id="tablaregistrarmaterias" class="table table-striped" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Nombre</th>
                        <th>id_estudiante</th>

                        <th>Edad</th>
                        <th>Email</th>
                        <th>Opciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $document) : ?>
                        <tr>
                            <td><?php echo $document['nombre']; ?></td>
                            <td><?php echo $document['id_estudiante']; ?></td>



                            <td><?php echo $document['edad']; ?></td>
                            <td><?php echo $document['email']; ?></td>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm btnEditar" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="<?php echo $document['_id']; ?>" data-nombre="<?php echo $document['nombre']; ?>" data-idestudiante="<?php echo $document['id_estudiante']; ?>" data-edad="<?php echo $document['edad']; ?>" data-email="<?php echo $document['email']; ?>">

                                    <i class="bi bi-pencil"></i> Editar
                                </button>


                                <button class="btn btn-danger btn-sm btnEliminar" data-id="<?php echo $document['_id']; ?>">

                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Estudiante</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm">
                                <div class="mb-3">
                                    <label for="editNombre" class="form-label">Nombre Completo:</label>
                                    <input type="text" class="form-control" id="editNombre" value="<?php echo $document->nombre ?>" name="editNombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editIdEstudiante" class="form-label">ID Estudiante:</label>
                                    <input type="number" class="form-control" id="editIdEstudiante" value="<?php echo $document->id_estudiante ?>" name="editIdEstudiante" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editEdad" class="form-label">Edad:</label>
                                    <input type="number" class="form-control" id="editEdad" value="<?php echo $document->edad ?>" name="editEdad" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editEmail" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="editEmail" value="<?php echo $document->email ?>"name="editEmail" required>
                                </div>
                                <input type="hidden" id="editIdEstudianteHidden" name="editIdEstudianteHidden">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btnGuardarCambios">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>





    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Incluir archivos JavaScript de Bootstrap -->
    <script>
      
        $(document).ready(function() {
        $('#tablaregistrarmaterias').DataTable();

        // Evento de clic en el botón de editar
        $('.btnEditar').click(function() {
            var idEstudiante = $(this).data('id');
            var nombre = $(this).data('nombre');
            var idEstudianteVal = $(this).data('idestudiante');
            var edad = $(this).data('edad');
            var email = $(this).data('email');

            // Actualizar los campos del formulario en el modal
            $('#editNombre').val(nombre);
            $('#editIdEstudiante').val(idEstudianteVal);
            $('#editEdad').val(edad);
            $('#editEmail').val(email);
            $('#editIdEstudianteHidden').val(idEstudiante);
        });
        // Evento de clic en el botón "Guardar cambios"
        $('#btnGuardarCambios').click(function() {
            // Obtener los valores de los campos del formulario
            var idEstudiante = $('#editIdEstudianteHidden').val();
            var nombre = $('#editNombre').val();
            var idEstudianteVal = $('#editIdEstudiante').val();
            var edad = $('#editEdad').val();
            var email = $('#editEmail').val();
               // Realizar solicitud AJAX para actualizar el registro
               $.ajax({
                url: 'actualizar.php',
                method: 'POST',
                data: {
                    id_estudiante: idEstudiante,
                    nombre: nombre,
                    idEstudiante: idEstudianteVal,
                    edad: edad,
                    email: email
                },
                success: function(response) {
                    // Manejar la respuesta del servidor
                    if (response === "ok") {
                        alert("Registro actualizado correctamente.");
                        location.reload();
                    } else {
                        // Mostrar mensaje de error
                        $('#errorMessage').text(response);
                        $('#errorMessage').show();

                        // Resaltar campos de entrada inválidos
                        if (response.includes("nombre")) {
                            $('#editNombre').addClass('is-invalid');
                        }
                        if (response.includes("id_estudiante")) {
                            $('#editIdEstudiante').addClass('is-invalid');
                        }
                        if (response.includes("edad")) {
                            $('#editEdad').addClass('is-invalid');
                        }
                        if (response.includes("email")) {
                            $('#editEmail').addClass('is-invalid');
                        }
                    }
                },
                error: function() {
                    alert("Error en la solicitud AJAX.");
                }
            });
        });
    });
    </script>
    

    <script src="eliminar.js"></script>
    <script>
        // Evento de clic en el botón de eliminar
        $('.btnEliminar').click(function() {
            var idEstudiante = $(this).data('id');

            if (confirm("¿Estás seguro de eliminar este registro?")) {
                // Realizar solicitud AJAX para eliminar el registro
                $.ajax({
                    url: 'eliminar.php',
                    method: 'POST',
                    data: {
                        id_estudiante: idEstudiante
                    },
                    success: function(response) {
                        // Manejar la respuesta del servidor
                        if (response === "ok") {
                            alert("Registro eliminado correctamente.");
                            location.reload();
                        } else {
                            alert("Error al eliminar el registro.");
                        }
                    },
                    error: function() {
                        alert("Error en la solicitud AJAX.");
                    }
                });
            }
        });
    </script>

</body>

</html>