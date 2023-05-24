<?php
require_once 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

// Conexión a la base de datos MongoDB
$mongoClient = new Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('asignaturas');
$collection = $database->selectCollection('materias');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstudiante = $_POST['id_estudiante'];

    try {
        // Convertir el ID a un objeto ObjectId de MongoDB
        $objectId = new ObjectId($idEstudiante);

        // Eliminar el registro basado en el campo _id
        $response = $collection->deleteOne(['_id' => $objectId]);

        if ($response->getDeletedCount() > 0) {
            echo "ok";
        } else {
            echo "error";
        }
    } catch (Exception $e) {
        echo "error";
    }
}
?>
