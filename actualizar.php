<?php
require_once 'vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('asignaturas');
$collection = $database->selectCollection('materias');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstudiante = $_POST['id_estudiante'];
    $nombre = $_POST['nombre'];
    $idEstudianteVal = $_POST['idEstudiante'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];

    // Validar los campos (puedes agregar tus propias validaciones aquí)
    $errors = [];
    if (empty($nombre)) {
        $errors[] = "El campo 'Nombre' es obligatorio.";
    }
    if (empty($idEstudianteVal)) {
        $errors[] = "El campo 'ID Estudiante' es obligatorio.";
    }
    if (empty($edad)) {
        $errors[] = "El campo 'Edad' es obligatorio.";
    }
    if (empty($email)) {
        $errors[] = "El campo 'Email' es obligatorio.";
    }

    // Verificar si hay errores
    if (!empty($errors)) {
        // Devolver los mensajes de error como una cadena separada por comas
        echo implode(", ", $errors);
        exit;
    }

    // Actualizar el documento en la base de datos
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($idEstudiante)],
        ['$set' => [
            'nombre' => $nombre,
            'id_estudiante' => $idEstudianteVal,
            'edad' => $edad,
            'email' => $email
        ]]
    );

    if ($result->getModifiedCount() > 0) {
        echo "ok"; // Éxito en la actualización
    } else {
        echo "Error al actualizar el registro.";
    }
}
?>
